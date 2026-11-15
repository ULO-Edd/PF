package com.example.parkjoy.Views;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.parkjoy.Listeners.EventoListener;
import com.example.parkjoy.Listeners.NovidadeListener;
import com.example.parkjoy.MainActivity;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.Favorito;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.User;
import com.example.parkjoy.R;
import com.google.android.material.navigation.NavigationView;

import org.json.JSONObject;

public class FavoriteActivity extends AppCompatActivity {
    public static final String ID_ATIVIDADE = "IDATIVIDADE";
    public final Context context = this;

    private Activities atividade;
    private TextView tvDesignacao, tvTipoAtividade, tvLotacao, tvDescricao;
    private ImageView imgActivity;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_favorite);

        int id = getIntent().getIntExtra(ID_ATIVIDADE, 0);
        atividade = SingletonParque.getInstance(getApplicationContext()).getActivity(id);

        tvDesignacao = findViewById(R.id.tv_designacao_fav);
        tvTipoAtividade = findViewById(R.id.tv_tipo_atividade_fav);
        tvLotacao = findViewById(R.id.tv_lotacao_fav);
        tvDescricao = findViewById(R.id.tv_descricao_fav);
        imgActivity = findViewById(R.id.iv_activity_fav);

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
