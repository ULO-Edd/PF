package com.example.parkjoy.Views;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.parkjoy.Models.Activities;

import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.R;

public class AtividadesActivity extends AppCompatActivity {
    public static final String ID_ATIVIDADE = "IDATIVIDADE";

    private Activities atividade;
    private TextView tvDesignacao, tvTipoAtividade, tvLotacao, tvDescricao;
    private ImageView imgActivity;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_atividade);

        int id = getIntent().getIntExtra(ID_ATIVIDADE, 0);
        atividade = SingletonParque.getInstance(getApplicationContext()).getActivity(id);

        tvDesignacao = findViewById(R.id.tv_designacao_act);
        tvTipoAtividade = findViewById(R.id.tv_tipo_atividade_act);
        tvLotacao = findViewById(R.id.tv_lotacao_act);
        tvDescricao = findViewById(R.id.tv_descricao_act);
        imgActivity = findViewById(R.id.iv_activity);

        if (atividade != null) {
            CarregarAtividade();
        }
    }

    private void CarregarAtividade(){
        tvDesignacao.setText(atividade.getDesignacao());
        tvDescricao.setText(atividade.getDescricao());
        tvTipoAtividade.setText("Tipo de Atividade: "+atividade.getTipoAtividade());
        tvLotacao.setText("Lotação: " + atividade.getLotacao());
        Glide.with(getApplicationContext())
                .load("http://"+ SingletonParque.getIP() +":8081/imgs/" + atividade.getImg())
                .placeholder(R.drawable.es500x500)
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .into(imgActivity);
    }

}
