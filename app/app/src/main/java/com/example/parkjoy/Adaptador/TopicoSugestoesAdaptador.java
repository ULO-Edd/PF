package com.example.parkjoy.Adaptador;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.example.parkjoy.Models.Topicos_Sugestoes;

import java.util.ArrayList;

public class TopicoSugestoesAdaptador extends BaseAdapter {

    private Context contexto;
    private LayoutInflater inflater;
    private ArrayList<Topicos_Sugestoes> topicos;

    public TopicoSugestoesAdaptador(Context contexto, ArrayList<Topicos_Sugestoes> topicos) {
        this.contexto = contexto;
        this.topicos = topicos;
    }

    @Override
    public int getCount() {
        return topicos.size();
    }

    @Override
    public Object getItem(int position) {
        return topicos.get(position);
    }

    @Override
    public long getItemId(int position) {
        return topicos.get(position).getId();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (inflater == null){
            inflater = (LayoutInflater) contexto.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (convertView == null){
            convertView = inflater.inflate(android.R.layout.simple_spinner_item, null);
        }

        TopicoSugestoesAdaptador.ViewHolderLista viewHolderLista = (TopicoSugestoesAdaptador.ViewHolderLista) convertView.getTag();
        if(viewHolderLista == null){
            viewHolderLista = new TopicoSugestoesAdaptador.ViewHolderLista(convertView);
            convertView.setTag(viewHolderLista);
        }
        viewHolderLista.update(topicos.get(position));

        return convertView;
    }

    private class ViewHolderLista{

        private TextView topico;

        public ViewHolderLista(View view) {
            topico = view.findViewById(android.R.id.text1);
        }

        public void update (Topicos_Sugestoes topicos){
            topico.setText(topicos.getTopico());
        }
    }
}
