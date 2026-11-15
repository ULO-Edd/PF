package com.example.parkjoy.Views;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.Toast;

import androidx.activity.result.ActivityResult;
import androidx.activity.result.ActivityResultCallback;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.example.parkjoy.Adaptador.ListaFavoritesAdaptador;
import com.example.parkjoy.Listeners.ActivitiesListener;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.R;

import java.util.ArrayList;

public class FavoritesListaFragment extends Fragment implements SwipeRefreshLayout.OnRefreshListener, ActivitiesListener {

    private ListView lvFavorites;
    private ArrayList<Activities> favorites;
    private SwipeRefreshLayout swipeRefreshLayout;

    private ActivityResultLauncher<Intent> activityResultLauncher;
    public FavoritesListaFragment() {

    }

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
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_favorites_lista, container, false);

        int id_user = SingletonParque.getInstance(getContext()).getUserId();

        lvFavorites = view.findViewById(R.id.lv_favorites);

        SingletonParque.getInstance(getContext()).setActivitiesListener(this);
        SingletonParque.getInstance(getContext()).getAllUserFavoritesAPI(getContext(), id_user);

        swipeRefreshLayout = view.findViewById(R.id.swipe_refresh_layuot_favoritos);
        swipeRefreshLayout.setOnRefreshListener(this);

        return view;
    }

    @Override
    public void onRefresh() {
        int id_user = SingletonParque.getInstance(getContext()).getUserId();
        SingletonParque.getInstance(getContext()).getAllUserFavoritesAPI(getContext(), id_user);
        swipeRefreshLayout.setRefreshing(false);
    }

    @Override
    public void onRefreshListaActivities(ArrayList<Activities> activities) {
        if (activities != null) {
            lvFavorites.setAdapter(new ListaFavoritesAdaptador(getContext(), activities, new Response.Listener() {
                @Override
                public void onResponse(Object response) {
                    Toast.makeText(getContext(), "Atividade Eliminada dos favoritos com sucesso", Toast.LENGTH_LONG).show();
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

