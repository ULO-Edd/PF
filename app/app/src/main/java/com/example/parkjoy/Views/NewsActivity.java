package com.example.parkjoy.Views;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.parkjoy.Models.News;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.R;

public class NewsActivity extends AppCompatActivity {
    public static final String ID_NOVIDADE = "IDNOVIDADE";

    private News novidade;
    private TextView tvTitulo, tvTexto;
    private ImageView Img;



      @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_news);

        int id = getIntent().getIntExtra(ID_NOVIDADE, 0);

        tvTitulo = findViewById(R.id.tv_title_news);
        tvTexto = findViewById(R.id.tv_text_news);
        Img = findViewById(R.id.iv_news);

        novidade = SingletonParque.getInstance(getApplicationContext()).getNovidade(id);


          if (novidade != null) {
            CarregarNovidade();
        }
    }

    private void CarregarNovidade(){
        setTitle("Novidade: " + novidade.getTitulo());
        tvTitulo.setText(novidade.getTitulo());
        tvTexto.setText(novidade.getDescricao());

        Glide.with(getApplicationContext())
                .load("http://"+ SingletonParque.getIP() +":8081/imgs/" + novidade.getImg())
                .placeholder(R.drawable.es500x500)
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .into(Img);

    }
}