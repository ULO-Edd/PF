package com.example.parkjoy.Views;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.Toast;

import androidx.fragment.app.Fragment;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.example.parkjoy.Adaptador.ListaActivitiesAdaptador;
import com.example.parkjoy.Adaptador.ListaActivitiesAddFavAdaptador;
import com.example.parkjoy.Adaptador.ListaFavoritesAdaptador;
import com.example.parkjoy.Listeners.ActivitiesListener;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.Favorito;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.R;

import java.util.ArrayList;

public class ActivityListaFragment extends Fragment implements SwipeRefreshLayout.OnRefreshListener, ActivitiesListener {
    private ListView lvActivity;
    private ArrayList<Activities> activities;
    private ArrayList<Favorito> favorites;
    private SwipeRefreshLayout swipeRefreshLayout;

    public ActivityListaFragment() {

    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_activities_lista, container, false);

        lvActivity = view.findViewById(R.id.lv_atividades);

        int userId = SingletonParque.getInstance(getContext()).getUserId();

        SingletonParque.getInstance(getContext()).setActivitiesListener(this);
        SingletonParque.getInstance(getContext()).getOnlyUserFavoritesAPI(getContext(), userId);
        SingletonParque.getInstance(getContext()).getAllAtividadesAPI(getContext());

        swipeRefreshLayout = view.findViewById(R.id.swipe_refresh_layuot_atividades);
        swipeRefreshLayout.setOnRefreshListener(this);

        return view;
    }

    @Override
    public void onRefresh() {
        int userId = SingletonParque.getInstance(getContext()).getUserId();
        SingletonParque.getInstance(getContext()).getOnlyUserFavoritesAPI(getContext(), userId);
        SingletonParque.getInstance(getContext()).getAllAtividadesAPI(getContext());
        swipeRefreshLayout.setRefreshing(false);
    }

    @Override
    public void onRefreshListaActivities(ArrayList<Activities> activities) {
        favorites = SingletonParque.getInstance(getContext()).parkBDHelper.getAllFavoritosBD();
        if (activities != null) {
            lvActivity.setAdapter(new ListaActivitiesAddFavAdaptador(getContext(), activities, favorites, new Response.Listener() {
                @Override
                public void onResponse(Object response) {
                    Toast.makeText(getContext(), "Atividade Adicionada aos favoritos com sucesso", Toast.LENGTH_LONG).show();
                    onRefresh();
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {

                }
            }));
        }
    }
}
