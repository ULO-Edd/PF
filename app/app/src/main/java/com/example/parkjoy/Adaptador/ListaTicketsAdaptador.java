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
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.Ticket;
import com.example.parkjoy.R;

import java.util.ArrayList;

public class ListaTicketsAdaptador extends BaseAdapter {

    private Context contexto;
    private LayoutInflater inflater;
    private ArrayList<Ticket> tickets;

    public ListaTicketsAdaptador(Context contexto, ArrayList<Ticket> tickets) {
        this.contexto = contexto;
        this.tickets = tickets;
    }

    @Override
    public int getCount() {
        return tickets.size();
    }

    @Override
    public Object getItem(int i) {
        return tickets.get(i);
    }

    @Override
    public long getItemId(int i) {
        return tickets.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (inflater == null){
            inflater = (LayoutInflater) contexto.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (view == null){
            view = inflater.inflate(R.layout.activity_ticket, null);
        }

        ViewHolderLista viewHolderLista = (ViewHolderLista) view.getTag();
        if(viewHolderLista == null){
            viewHolderLista = new ViewHolderLista(view);
            view.setTag(viewHolderLista);
        }
        viewHolderLista.update(tickets.get(i));

        return view;
    }

    private class ViewHolderLista{
        private TextView tvTituloTicket, tvDataDeCompra, tvPreco;

        public ViewHolderLista(View view) {
            tvTituloTicket = view.findViewById(R.id.tv_title_ticket);
            tvDataDeCompra = view.findViewById(R.id.tv_data_de_compra_ticket);
            tvPreco = view.findViewById(R.id.tv_preco_ticket);
        }

        public void update (Ticket ticket){
            tvTituloTicket.setText("Bilhete: " + ticket.getDataDeUso());
            tvDataDeCompra.setText("Data de Compra: " + ticket.getDataDeCompra());
            tvPreco.setText("Preço: " + ticket.getPreco() + "€");
        }
    }
}
