package com.example.parkjoy.Views;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.R;

public class AtividadeAddFavActivity extends AppCompatActivity {
    public static final String ID_ATIVIDADE = "IDATIVIDADE";
    public final Context context = this;

    private Activities atividade;
    private TextView tvDesignacao, tvTipoAtividade, tvLotacao, tvDescricao;
    private ImageView imgActivity;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_atividade_add_fav);

        int id = getIntent().getIntExtra(ID_ATIVIDADE, 0);
        atividade = SingletonParque.getInstance(getApplicationContext()).getActivity(id);

        tvDesignacao = findViewById(R.id.tv_designacao_add_fav);
        tvTipoAtividade = findViewById(R.id.tv_tipo_atividade_add_fav);
        tvLotacao = findViewById(R.id.tv_lotacao_add_fav);
        tvDescricao = findViewById(R.id.tv_descricao_add_fav);
        imgActivity = findViewById(R.id.iv_activity_add_fav);

        if (atividade != null) {
            CarregarAtividade();
        }
    }

    private void CarregarAtividade() {
        tvDesignacao.setText(atividade.getDesignacao());
        tvDescricao.setText(atividade.getDescricao());
        tvTipoAtividade.setText("Tipo de Atividade: " + atividade.getTipoAtividade());
        tvLotacao.setText("Lotação: " + atividade.getLotacao());
        Glide.with(getApplicationContext())
                .load("http://" + SingletonParque.getIP() + ":8081/imgs/" + atividade.getImg())
                .placeholder(R.drawable.es500x500)
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .into(imgActivity);
    }
}
