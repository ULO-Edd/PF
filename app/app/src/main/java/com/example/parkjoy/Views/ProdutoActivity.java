package com.example.parkjoy.Views;

import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.Produto;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.R;

public class ProdutoActivity extends AppCompatActivity {
    public static final String ID_PRODUTO = "ID_PRODUTO";

    private Produto produto;
    private TextView tvDescricao, tvPreco, tvQuantidade;
    private ImageView imgProduto;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_produto);

        int id = getIntent().getIntExtra(ID_PRODUTO, 0);
        produto = SingletonParque.getInstance(getApplicationContext()).getProduto(id);

        tvDescricao = findViewById(R.id.tv_descricao_pdc);
        tvPreco = findViewById(R.id.tv_pontos_pdc);
        tvQuantidade = findViewById(R.id.tv_quantidade_pdc);
        imgProduto = findViewById(R.id.iv_produto);

        if (produto != null) {
            CarregarProduto();
        }
    }

    private void CarregarProduto(){
        setTitle(produto.getDescricao());
        tvDescricao.setText("Descriçao: " + produto.getDescricao());
        tvPreco.setText("Preço: " + produto.getPontos() + " pontos");
        tvQuantidade.setText("Quantidade: "+ produto.getQuantidade());
        Glide.with(getApplicationContext())
                .load("http://"+ SingletonParque.getIP() +":8081/imgs/" + produto.getImg())
                .placeholder(R.drawable.es500x500)
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .into(imgProduto);
    }

}
