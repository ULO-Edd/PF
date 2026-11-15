package com.example.parkjoy.Adaptador;

import android.content.Context;
import android.content.DialogInterface;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;

import com.android.volley.Response;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.parkjoy.Listeners.EventoListener;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.Favorito;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.User;
import com.example.parkjoy.R;

import org.json.JSONObject;

import java.util.ArrayList;

public class ListaActivitiesAddFavAdaptador extends BaseAdapter {

    private Context contexto;
    private LayoutInflater inflater;
    private ArrayList<Activities> activity;
    private ArrayList<Favorito> favoritos;
    private Activities atividade;
    private Response.Listener<JSONObject> onResponse;
    private Response.ErrorListener onError;

    public ListaActivitiesAddFavAdaptador(Context contexto, ArrayList<Activities> activities, ArrayList<Favorito> favorites, Response.Listener onResponse, Response.ErrorListener errors) {
        this.contexto = contexto;
        this.activity = activities;
        this.favoritos = favorites;
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
            view = inflater.inflate(R.layout.activity_atividade_add_fav, null);
        }

        boolean isFavorite = false;
        for (Favorito favorito : favoritos) {
            if(favorito.getId_atividade() == this.getItemId(a)){
                isFavorite = true;
            }
        }


        Button myButton = view.findViewById(R.id.btn_add_favorito);
        myButton.setTag(this.getItemId(a));
        myButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                long modelId = (long) view.getTag();
                int id = (int) modelId;


                User user = SingletonParque.getInstance(contexto).parkBDHelper.getUserBD();

                atividade = SingletonParque.getInstance(contexto).parkBDHelper.getAtividadeBD(id);

                AlertDialog.Builder builder = new AlertDialog.Builder(contexto);
                builder.setTitle("Adicionar");
                builder.setMessage("Pretende adicionar esta atividade aos favoritos?");
                builder.setPositiveButton("YES", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int which) {
                        SingletonParque.getInstance(contexto).addFavoritoAPI(user.getId(), atividade.getId(), contexto, onResponse, onError);
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

        ListaActivitiesAddFavAdaptador.ViewHolderLista viewHolderLista = (ListaActivitiesAddFavAdaptador.ViewHolderLista) view.getTag();
        if (viewHolderLista == null) {
            viewHolderLista = new ListaActivitiesAddFavAdaptador.ViewHolderLista(view);
            view.setTag(viewHolderLista);
        }
        viewHolderLista.update(activity.get(a), isFavorite);
        return view;
    }

    private class ViewHolderLista{

        private TextView tvDescricao, tvTipoAtividade, tvLotacao, tvDesignacao;
        private ImageView imgActivity;
        private Button btnAddFav;

        public ViewHolderLista(View view) {
            tvDescricao = view.findViewById(R.id.tv_descricao_add_fav);
            tvTipoAtividade = view.findViewById(R.id.tv_tipo_atividade_add_fav);
            tvLotacao = view.findViewById(R.id.tv_lotacao_add_fav);
            tvDesignacao = view.findViewById(R.id.tv_designacao_add_fav);
            imgActivity = view.findViewById(R.id.iv_activity_add_fav);
            btnAddFav = view.findViewById(R.id.btn_add_favorito);
        }

        public void update (Activities activities, boolean isFavorite){
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


            if(isFavorite){
                btnAddFav.setClickable(false);
                btnAddFav.setVisibility(View.GONE);
            }else {
                btnAddFav.setClickable(true);
                btnAddFav.setVisibility(View.VISIBLE);
            }
        }

    }
}

