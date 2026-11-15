package com.example.parkjoy.Views;

import androidx.activity.result.ActivityResult;
import androidx.activity.result.ActivityResultCallback;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.FragmentManager;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.example.parkjoy.Adaptador.ListaActivitiesAdaptador;
import com.example.parkjoy.Adaptador.ListaFavoritesAdaptador;
import com.example.parkjoy.Listeners.ActivitiesListener;
import com.example.parkjoy.MainActivity;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.Ticket;
import com.example.parkjoy.Models.User;
import com.example.parkjoy.R;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.Locale;

public class TicketDetailActivity extends AppCompatActivity implements SwipeRefreshLayout.OnRefreshListener {

    public static final String ID_TICKET = "ID_TICKET";
    private Ticket ticket;
    private TextView tvDataDeCompra, tvPreco, tvTitle;
    private ListView lvTicketActivities;
    private SwipeRefreshLayout swipeRefreshLayout;
    private ActivityResultLauncher<Intent> activityResultLauncher;
    private FragmentManager fragmentManager;
    private ArrayList<Activities> atividades;
    private String currentDate = new SimpleDateFormat("yyyy-MM-dd", Locale.getDefault()).format(new Date());

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_ticket_detail);

        int id = getIntent().getIntExtra(ID_TICKET, 0);
        ticket = SingletonParque.getInstance(getApplicationContext()).getTickets(id);

        tvTitle = findViewById(R.id.tv_title_ticket_det);
        tvDataDeCompra = findViewById(R.id.tv_data_de_compra_ticket_det);
        tvPreco = findViewById(R.id.tv_preco_ticket_det);
        fragmentManager = getSupportFragmentManager();

        activityResultLauncher = registerForActivityResult(new ActivityResultContracts.StartActivityForResult()
                , new ActivityResultCallback<ActivityResult>() {
                    @Override
                    public void onActivityResult(ActivityResult result) {

                    }
                });

        if (ticket != null) {
            CarregarTicket();
        }

        lvTicketActivities = findViewById(R.id.lvticketActivities);
        swipeRefreshLayout = findViewById(R.id.swipe_refresh_layout_ticket_activities);
        swipeRefreshLayout.setOnRefreshListener(this);

        atividades = SingletonParque.getInstance(getApplicationContext()).getAllAtividadesBD();


        if (atividades != null) {
            lvTicketActivities.setAdapter(new ListaActivitiesAdaptador(getApplicationContext(), atividades));

        }

        lvTicketActivities.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                if (currentDate.equals(ticket.getDataDeUso())) {
                    Intent intent = new Intent(getApplicationContext(), AtividadesDetailActivity.class);
                    Activities activity = (Activities) lvTicketActivities.getItemAtPosition(i);
                    intent.putExtra(AtividadesDetailActivity.ID_ATIVIDADE, activity.getId());
                    activityResultLauncher.launch(intent);
                }
            }
        });
    }


    private void CarregarTicket(){
        setTitle("Bilhete: " + ticket.getDataDeUso());
        tvTitle.setText("Bilhete: " + ticket.getDataDeUso());
        tvDataDeCompra.setText("Data de Compra: " + ticket.getDataDeCompra());
        tvPreco.setText("Preço: " + ticket.getPreco() + "€");

    }

    @Override
    public void onRefresh() {
        SingletonParque.getInstance(getApplicationContext()).getAllTicketActivitiesAPI(getApplicationContext(), ticket.getId());
        swipeRefreshLayout.setRefreshing(false);
    }
}