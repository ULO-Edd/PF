package com.example.parkjoy.Views;

import android.app.Activity;
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

import com.example.parkjoy.Adaptador.ListaNewsAdaptador;
import com.example.parkjoy.Listeners.NovidadesListener;
import com.example.parkjoy.MainActivity;
import com.example.parkjoy.Models.News;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.R;
import com.google.android.material.snackbar.Snackbar;

import java.util.ArrayList;


public class NewsListaFragment extends Fragment implements SwipeRefreshLayout.OnRefreshListener, NovidadesListener {

    private ListView lvNews;
    private ArrayList<News> news;
    private SwipeRefreshLayout swipeRefreshLayout;

    private ActivityResultLauncher<Intent> activityResultLauncher;

    public NewsListaFragment() {

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
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_news_lista, container, false);

        lvNews = view.findViewById(R.id.lvnews);

        swipeRefreshLayout = view.findViewById(R.id.swipe_refresh_layuot_news);
        swipeRefreshLayout.setOnRefreshListener(this);

        SingletonParque.getInstance(getContext()).setNovidadesListener(this);
        SingletonParque.getInstance(getContext()).getAllNovidadesAPI(getContext());

        return view;
    }

    @Override
    public void onRefresh() {
        SingletonParque.getInstance(getContext()).getAllNovidadesAPI(getContext());
        swipeRefreshLayout.setRefreshing(false);
    }

    @Override
    public void onRefreshListaNews(ArrayList<News> listaNews) {
        if (listaNews != null){
            lvNews.setAdapter(new ListaNewsAdaptador(getContext(), listaNews));
        }
    }

    @Override
    public void onRefreshNovidade() {
        ArrayList<News> arrayListNovidades = SingletonParque.getInstance(getContext()).parkBDHelper.getAllNoticiasBD();

        lvNews.setAdapter(new ListaNewsAdaptador(getContext(), arrayListNovidades));
    }
}