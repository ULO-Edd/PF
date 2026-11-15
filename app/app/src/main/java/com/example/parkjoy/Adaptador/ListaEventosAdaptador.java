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
import com.example.parkjoy.Models.Evento;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.Ticket;
import com.example.parkjoy.R;

import java.util.ArrayList;

public class ListaEventosAdaptador extends BaseAdapter {

    private Context contexto;
    private LayoutInflater inflater;
    private ArrayList<Evento> eventos;

    public ListaEventosAdaptador(Context contexto, ArrayList<Evento> eventos) {
        this.contexto = contexto;
        this.eventos = eventos;
    }

    @Override
    public int getCount() {
        return eventos.size();
    }

    @Override
    public Object getItem(int i) {
        return eventos.get(i);
    }

    @Override
    public long getItemId(int i) {
        return eventos.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (inflater == null){
            inflater = (LayoutInflater) contexto.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (view == null){
            view = inflater.inflate(R.layout.activity_eventos, null);
        }

        ViewHolderLista viewHolderLista = (ViewHolderLista) view.getTag();
        if(viewHolderLista == null){
            viewHolderLista = new ViewHolderLista(view);
            view.setTag(viewHolderLista);
        }
        viewHolderLista.update(eventos.get(i));

        return view;
    }

    private class ViewHolderLista{
        private TextView  tvDataDeInicio, tvDataDeConclusao, tvDesignacao, tvDescricao, tvPontosParticipacao;
        private ImageView imgEvento;

        public ViewHolderLista(View view) {
            tvDataDeInicio = view.findViewById(R.id.tv_data_de_inicio_evento);
            tvDataDeConclusao = view.findViewById(R.id.tv_data_de_conclusao_evento);
            tvDesignacao = view.findViewById(R.id.tv_designacao_evento);
            tvDescricao = view.findViewById(R.id.tv_descricao_evento);
            tvPontosParticipacao = view.findViewById(R.id.tv_pontos_participacao_evento);
            imgEvento = view.findViewById(R.id.iv_evento);
        }

        public void update (Evento evento){
            tvDesignacao.setText("Evento: " + evento.getDesignacao());
            tvDescricao.setText("Descrição: " + evento.getDescricao());
            tvDataDeInicio.setText("Data de Inicio: " + evento.getDataInicio());
            tvDataDeConclusao.setText("Data de Conclusão: " + evento.getDataConclusao());
            tvPontosParticipacao.setText("Pontos ao participar: " + evento.getPontosParticipacao());
            Glide.with(contexto)
                    .load("http://"+ SingletonParque.getIP()+":8081/imgs/" + evento.getImg())
                    .placeholder(R.drawable.es500x500)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgEvento);
        }
    }
}
