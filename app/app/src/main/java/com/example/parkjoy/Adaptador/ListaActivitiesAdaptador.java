package com.example.parkjoy.Adaptador;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.R;

import java.util.ArrayList;

public class ListaActivitiesAdaptador extends BaseAdapter {

    private Context contexto;
    private LayoutInflater inflater;
    private ArrayList<Activities> activity;

    public ListaActivitiesAdaptador(Context contexto, ArrayList<Activities> activities) {
        this.contexto = contexto;
        this.activity = activities;
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
            view = inflater.inflate(R.layout.activity_atividade, null);
        }
        ViewHolderLista viewHolderLista = (ViewHolderLista) view.getTag();
        if (viewHolderLista == null) {
            viewHolderLista = new ViewHolderLista(view);
            view.setTag(viewHolderLista);
        }
        viewHolderLista.update(activity.get(a));
        return view;
    }

    private class ViewHolderLista{

        private TextView tvDescricao, tvTipoAtividade, tvLotacao, tvDesignacao;
        private ImageView imgActivity;

        public ViewHolderLista(View view) {
            tvDescricao = view.findViewById(R.id.tv_descricao_act);
            tvTipoAtividade = view.findViewById(R.id.tv_tipo_atividade_act);
            tvLotacao = view.findViewById(R.id.tv_lotacao_act);
            tvDesignacao = view.findViewById(R.id.tv_designacao_act);
            imgActivity = view.findViewById(R.id.iv_activity);
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
