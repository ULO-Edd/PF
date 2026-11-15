package com.example.parkjoy.Views;

import androidx.activity.result.ActivityResult;
import androidx.activity.result.ActivityResultCallback;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.appcompat.app.AppCompatActivity;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.content.Intent;
import android.os.Bundle;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.parkjoy.Adaptador.ListaActivitiesAdaptador;
import com.example.parkjoy.Listeners.ActivitiesListener;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.Evento;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.User;
import com.example.parkjoy.R;

import java.util.ArrayList;

public class EventosDetailActivity extends AppCompatActivity implements SwipeRefreshLayout.OnRefreshListener {

    public static final String ID_EVENTO = "ID_EVENTO";
    private Evento evento;
    private TextView  tvDataDeInicio, tvDataDeConclusao, tvDesignacao, tvDescricao, tvPontosParticipacao;
    private ImageView imgEvento;
    private ListView lvEventoActivities;
    private ActivityResultLauncher<Intent> activityResultLauncher;
    private ArrayList<Activities> atividades;
    private SwipeRefreshLayout swipeRefreshLayout;
    private int id;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_eventos_detail);

        id = getIntent().getIntExtra(ID_EVENTO, 0);
        evento = SingletonParque.getInstance(getApplicationContext()).getEvento(id);

        tvDataDeInicio = findViewById(R.id.tv_data_de_inicio_detail_evento);
        tvDataDeConclusao = findViewById(R.id.tv_data_de_conclusao_detail_evento);
        tvDesignacao = findViewById(R.id.tv_designacao_detail_evento);
        tvDescricao = findViewById(R.id.tv_descricao_detail_evento);
        tvPontosParticipacao = findViewById(R.id.tv_pontos_participacao_detail_evento);
        imgEvento = findViewById(R.id.iv_detail_evento);

        activityResultLauncher = registerForActivityResult(new ActivityResultContracts.StartActivityForResult()
                , new ActivityResultCallback<ActivityResult>() {
                    @Override
                    public void onActivityResult(ActivityResult result) {

                    }
                });

        if (evento != null) {
            CarregarEvento();
        }

        lvEventoActivities = findViewById(R.id.lveventoActivities);

        swipeRefreshLayout = findViewById(R.id.swipe_refresh_layout_evento_activities);
        swipeRefreshLayout.setOnRefreshListener(this);

        atividades = SingletonParque.getInstance(getApplicationContext()).getAllAtividadesBD();

        if (atividades != null) {
            lvEventoActivities.setAdapter(new ListaActivitiesAdaptador(getApplicationContext(), atividades));

        }
    }

    private void CarregarEvento(){
        tvDesignacao.setText("Evento: " + evento.getDesignacao());
        tvDescricao.setText("Descrição: " + evento.getDescricao());
        tvDataDeInicio.setText("Data de Inicio: " + evento.getDataInicio());
        tvDataDeConclusao.setText("Data de Conclusão: " + evento.getDataConclusao());
        tvPontosParticipacao.setText("Pontos ao participar: " + evento.getPontosParticipacao());
        Glide.with(getApplicationContext())
                .load("http://"+ SingletonParque.getIP()+":8081/imgs/" + evento.getImg())
                .placeholder(R.drawable.es500x500)
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .into(imgEvento);
    }

    @Override
    public void onRefresh() {
        SingletonParque.getInstance(getApplicationContext()).getAllEventActivitiesAPI(getApplicationContext(), id);
        swipeRefreshLayout.setRefreshing(false);
    }
}