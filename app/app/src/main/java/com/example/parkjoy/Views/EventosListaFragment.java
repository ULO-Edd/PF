package com.example.parkjoy.Views;

import android.content.Intent;
import android.os.Bundle;

import androidx.activity.result.ActivityResult;
import androidx.activity.result.ActivityResultCallback;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.fragment.app.Fragment;

import android.os.CountDownTimer;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;

import com.example.parkjoy.Adaptador.ListaEventosAdaptador;
import com.example.parkjoy.Listeners.ActivitiesListener;
import com.example.parkjoy.Listeners.EventosListener;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.Evento;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.R;

import java.util.ArrayList;
import java.util.Timer;
import java.util.TimerTask;

public class EventosListaFragment extends Fragment implements EventosListener, ActivitiesListener {

    private ListView lvEventos;
    private ArrayList<Evento> eventos;
    private Intent pendingIntent = null;

    private ActivityResultLauncher<Intent> activityResultLauncher;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        activityResultLauncher = registerForActivityResult(new ActivityResultContracts.StartActivityForResult()
                , new ActivityResultCallback<ActivityResult>() {
                    @Override
                    public void onActivityResult(ActivityResult result) {

                    }
                });
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_eventos_lista, container, false);

        lvEventos = view.findViewById(R.id.lv_eventos);

        lvEventos.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {


                Intent intent = new Intent(getContext(), EventosDetailActivity.class);
                Evento evento = (Evento) lvEventos.getItemAtPosition(i);
                intent.putExtra(EventosDetailActivity.ID_EVENTO, evento.getId());
                pendingIntent = intent;
                SingletonParque.getInstance(getContext()).getAllEventActivitiesAPI(getContext(), evento.getId());
            }
        });

        SingletonParque.getInstance(getContext()).setActivitiesListener(this);
        SingletonParque.getInstance(getContext()).setEventosListener(this);
        SingletonParque.getInstance(getContext()).getAllEventosAPI(getContext());

        return view;
    }

    @Override
    public void onRefreshListaEventos(ArrayList<Evento> eventos) {
        lvEventos.setAdapter(new ListaEventosAdaptador(getContext(), eventos));
    }

    @Override
    public void onRefreshListaActivities(ArrayList<Activities> activities) {
        if(pendingIntent != null) {
            activityResultLauncher.launch(pendingIntent);
        }
        pendingIntent = null;
    }
}