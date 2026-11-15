package com.example.parkjoy.Views;

import android.content.Intent;
import android.os.Bundle;

import androidx.activity.result.ActivityResult;
import androidx.activity.result.ActivityResultCallback;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;

import com.example.parkjoy.Adaptador.ListaActivitiesAdaptador;
import com.example.parkjoy.Adaptador.ListaTicketsAdaptador;
import com.example.parkjoy.Listeners.ActivitiesListener;
import com.example.parkjoy.Listeners.TicketsListener;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.News;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.Ticket;
import com.example.parkjoy.R;

import java.util.ArrayList;

public class TicketListaFragment extends Fragment implements SwipeRefreshLayout.OnRefreshListener, TicketsListener, ActivitiesListener {

    private ListView lvTickets;
    private ArrayList<Ticket> tickets;
    private SwipeRefreshLayout swipeRefreshLayout;
    private Intent pendingIntent = null;

    private ActivityResultLauncher<Intent> activityResultLauncher;

    public TicketListaFragment() {

    }

    @Override
    public void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        activityResultLauncher = registerForActivityResult(new ActivityResultContracts.StartActivityForResult()
                , new ActivityResultCallback<ActivityResult>() {
                    @Override
                    public void onActivityResult(ActivityResult result) {

                    }
                });
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_ticket_lista, container, false);

        int id = SingletonParque.getInstance(getContext()).getUserId();

        lvTickets = view.findViewById(R.id.lvtickets);

        lvTickets.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {

                Intent intent = new Intent(getContext(), TicketDetailActivity.class);
                Ticket ticket = (Ticket) lvTickets.getItemAtPosition(i);
                intent.putExtra(TicketDetailActivity.ID_TICKET, ticket.getId());
                pendingIntent = intent;
                SingletonParque.getInstance(getContext()).getAllTicketActivitiesAPI(getContext(), ticket.getId());
            }
        });

        swipeRefreshLayout = view.findViewById(R.id.swipe_refresh_layuot_tickets);
        swipeRefreshLayout.setOnRefreshListener(this);


        SingletonParque.getInstance(getContext()).setTicketsListener(this);
        SingletonParque.getInstance(getContext()).setActivitiesListener(this);
        SingletonParque.getInstance(getContext()).getAllUserTicketsAPI(getContext(), id);

        return view;
    }

    @Override
    public void onRefresh() {

    }

    @Override
    public void onRefreshTickets(ArrayList<Ticket> tickets) {
        lvTickets.setAdapter(new ListaTicketsAdaptador(getContext(), tickets));
    }

    @Override
    public void onRefreshListaActivities(ArrayList<Activities> activities) {
        if(pendingIntent != null) {
            activityResultLauncher.launch(pendingIntent);
        }
        pendingIntent = null;
    }
}