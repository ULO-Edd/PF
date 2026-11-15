package com.example.parkjoy.Views;

import android.graphics.Bitmap;
import android.graphics.Color;
import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.Pessoa;
import com.example.parkjoy.Models.Produto;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.User;
import com.example.parkjoy.R;
import com.google.zxing.BarcodeFormat;
import com.google.zxing.WriterException;
import com.google.zxing.common.BitMatrix;
import com.google.zxing.qrcode.QRCodeWriter;

import org.json.JSONException;
import org.json.JSONObject;

public class ProdutoDetailActivity extends AppCompatActivity {
    public static final String ID_PRODUTO = "ID_PRODUTO";
    private Produto produto;
    private Pessoa pessoa;
    private TextView tvDescricao, tvQuantidade, tvPreco, tvPontosUser;
    private ImageView imgPdcQRcode;
    private Bitmap bmp;
    int id = 0;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_produto_detail);
        id = getIntent().getIntExtra(ID_PRODUTO, 0);
        produto = SingletonParque.getInstance(getApplicationContext()).getProduto(id);
        pessoa = SingletonParque.getInstance(getApplicationContext()).parkBDHelper.getPessoaBD();

        tvDescricao = findViewById(R.id.tv_descricao_pdc_det);
        tvQuantidade = findViewById(R.id.tv_quantidade_pdc_det);
        tvPreco = findViewById(R.id.tv_preco_pdc_det);
        tvPontosUser = findViewById(R.id.tv_pontos_user_pdc_det);
        imgPdcQRcode = findViewById(R.id.iv_QRcode_pdc_det);


        try {
            JSONObject data = new JSONObject();
            data.put("produto", produto.getId());
            data.put("user", pessoa.getId());

            QRCodeWriter writer = new QRCodeWriter();
            BitMatrix bitMatrix = null;
            bitMatrix = writer.encode(data.toString(), BarcodeFormat.QR_CODE, 250, 250);

            int width = bitMatrix.getWidth();
            int height = bitMatrix.getHeight();
            bmp = Bitmap.createBitmap(width, height, Bitmap.Config.RGB_565);
            for (int x = 0; x < width; x++) {
                for (int y = 0; y < height; y++) {
                    bmp.setPixel(x, y, bitMatrix.get(x, y) ? Color.BLACK : Color.WHITE);
                }
            }
        } catch (WriterException | JSONException e) {
            e.printStackTrace();
        }

        if (produto != null) {
            CarregarProduto();
            imgPdcQRcode.setImageBitmap(bmp);
        }
    }

    private void CarregarProduto() {
        tvDescricao.setText("Comprar: " + produto.getDescricao());
        tvQuantidade.setText("Quantidade: " + produto.getQuantidade());
        tvPreco.setText("Preço: " + produto.getPontos() + " pontos");
        tvPontosUser.setText("" + pessoa.getPoints());
    }
}
