package com.example.parkjoy.Views;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.parkjoy.MainActivity;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.Favorito;
import com.example.parkjoy.Models.Participar;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.User;
import com.example.parkjoy.R;
import com.example.parkjoy.Utils.ParkJsonParser;
import com.google.zxing.BarcodeFormat;
import com.google.zxing.WriterException;
import com.google.zxing.common.BitMatrix;
import com.google.zxing.qrcode.QRCodeWriter;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class AtividadesDetailActivity extends AppCompatActivity {
    public static final String ID_ATIVIDADE = "IDATIVIDADE";

    private Activities atividade;
    private User user;
    private TextView tvTipoAtividade, tvLotacao, tvDesignacao;
    private ImageView imgQRcode;
    private Bitmap bmp;
    int id = 0;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_atividades_detail);
        id = getIntent().getIntExtra(ID_ATIVIDADE, 0);
        atividade = SingletonParque.getInstance(getApplicationContext()).getActivity(id);
        user = SingletonParque.getInstance(getApplicationContext()).parkBDHelper.getUserBD();

        tvTipoAtividade = findViewById(R.id.tv_tipo_atividade_act_det);
        tvLotacao = findViewById(R.id.tv_lotacao_act_det);
        tvDesignacao = findViewById(R.id.tv_designacao_act_det);
        imgQRcode = findViewById(R.id.iv_QRcode_atv_det);


        try {
            JSONObject data = new JSONObject();
            data.put("atividade", atividade.getId());
            data.put("user", user.getId());

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

        if (atividade != null) {
            CarregarAtividade();
            imgQRcode.setImageBitmap(bmp);
        }
    }

    private void CarregarAtividade() {
        tvDesignacao.setText("Participar: " + atividade.getDesignacao());
        tvTipoAtividade.setText("Tipo de Atividade: " + atividade.getTipoAtividade());
        tvLotacao.setText("Lotação: " + atividade.getLotacao());
    }
}
