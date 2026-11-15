package com.example.parkjoy.Adaptador;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.parkjoy.Listeners.EventoListener;
import com.example.parkjoy.MainActivity;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.Favorito;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.User;
import com.example.parkjoy.R;
import com.example.parkjoy.Views.FavoriteActivity;

import org.json.JSONObject;

import java.util.ArrayList;

public class ListaFavoritesAdaptador extends BaseAdapter {

    private Context contexto;
    private LayoutInflater inflater;
    private ArrayList<Activities> activity;
    private Favorito favorito;
    private Response.Listener<JSONObject> onResponse;
    private Response.ErrorListener onError;

    public ListaFavoritesAdaptador(Context contexto, ArrayList<Activities> activities, Response.Listener onResponse, Response.ErrorListener errors) {
        this.contexto = contexto;
        this.activity = activities;
        this.onResponse = onResponse;
        this.onError = errors;
    }


    @Override
    public int getCount() {
        return activity.size();
    }

    @Override
    public Object getItem(int a) {
        return activity.get(a);
    }

    @Override
    public long getItemId(int a) {
        return activity.get(a).getId();
    }

    @Override
    public View getView(int a, View view, ViewGroup viewGroup) {
        if (inflater == null) {
            inflater = (LayoutInflater) contexto.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (view == null) {
            view = inflater.inflate(R.layout.activity_favorite, null);
        }
        Button myButton = view.findViewById(R.id.btn_del_favorito);
        myButton.setTag(this.getItemId(a));
        myButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                long modelId = (long) view.getTag();
                int id = (int) modelId;
                User user = SingletonParque.getInstance(contexto).parkBDHelper.getUserBD();

                favorito = SingletonParque.getInstance(contexto).parkBDHelper.getFavoritoBD(id);

                AlertDialog.Builder builder = new AlertDialog.Builder(contexto);
                builder.setTitle("Remover");
                builder.setMessage("Pretende mesmo remover esta atividade dos favoritos?");
                builder.setPositiveButton("YES", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int which) {
                        SingletonParque.getInstance(contexto).parkBDHelper.removerFavoritoBD();
                        SingletonParque.getInstance(contexto).delFavoritoAPI(user.getId(), favorito.getId_atividade(), contexto, onResponse, onError);
                    }
                });
                builder.setNegativeButton("NO", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int which) {
                        // Do something when user press the negative button
                    }
                });

                AlertDialog alertDialog = builder.create();
                alertDialog.show();
            }
        });

        ListaFavoritesAdaptador.ViewHolderLista viewHolderLista = (ListaFavoritesAdaptador.ViewHolderLista) view.getTag();
        if (viewHolderLista == null) {
            viewHolderLista = new ListaFavoritesAdaptador.ViewHolderLista(view);
            view.setTag(viewHolderLista);
        }
        viewHolderLista.update(activity.get(a));
        return view;
    }

    private class ViewHolderLista{

        private TextView tvDescricao, tvTipoAtividade, tvLotacao, tvDesignacao;
        private ImageView imgActivity;

        public ViewHolderLista(View view) {
            tvDescricao = view.findViewById(R.id.tv_descricao_fav);
            tvTipoAtividade = view.findViewById(R.id.tv_tipo_atividade_fav);
            tvLotacao = view.findViewById(R.id.tv_lotacao_fav);
            tvDesignacao = view.findViewById(R.id.tv_designacao_fav);
            imgActivity = view.findViewById(R.id.iv_activity_fav);
        }

        public void update (Activities activities){
            System.out.println("--->" + activities.getDescricao());


            tvDescricao.setText("Descrição: " + activities.getDescricao());
            tvDesignacao.setText(activities.getDesignacao());
            tvTipoAtividade.setText("Tipo de Atividade: " + activities.getTipoAtividade());
            tvLotacao.setText("Lotação: " + activities.getLotacao());
            Glide.with(contexto)
                    .load("http://"+ SingletonParque.getIP()+":8081/imgs/" + activities.getImg())
                    .placeholder(R.drawable.es500x500)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgActivity);
        }

    }
}

