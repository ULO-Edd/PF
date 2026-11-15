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
import com.example.parkjoy.Models.Produto;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.R;

import java.util.ArrayList;

public class ListaProdutosAdaptador extends BaseAdapter {

    private Context contexto;
    private LayoutInflater inflater;
    private ArrayList<Produto> produtos;

    public ListaProdutosAdaptador(Context contexto, ArrayList<Produto> products) {
        this.contexto = contexto;
        this.produtos = products;
    }


    @Override
    public int getCount() {
        return produtos.size();
    }

    @Override
    public Object getItem(int a) {
        return produtos.get(a);
    }

    @Override
    public long getItemId(int a) {
        return produtos.get(a).getId();
    }

    @Override
    public View getView(int a, View view, ViewGroup viewGroup) {
        if (inflater == null) {
            inflater = (LayoutInflater) contexto.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (view == null) {
            view = inflater.inflate(R.layout.activity_produto, null);
        }
        ViewHolderLista viewHolderLista = (ViewHolderLista) view.getTag();
        if (viewHolderLista == null) {
            viewHolderLista = new ViewHolderLista(view);
            view.setTag(viewHolderLista);
        }
        viewHolderLista.update(produtos.get(a));
        return view;
    }

    private class ViewHolderLista{

        private TextView tvDescricao, tvPreco, tvQuantidade;
        private ImageView imgProduto;

        public ViewHolderLista(View view) {
            tvDescricao = view.findViewById(R.id.tv_descricao_pdc);
            tvPreco = view.findViewById(R.id.tv_pontos_pdc);
            tvQuantidade = view.findViewById(R.id.tv_quantidade_pdc);
            imgProduto = view.findViewById(R.id.iv_produto);
        }

        public void update (Produto produto){
            System.out.println("--->" + produto.getDescricao());

            tvDescricao.setText("Descriçao: " + produto.getDescricao());
            tvPreco.setText("Preço: " + produto.getPontos() + " pontos");
            tvQuantidade.setText("Quantidade: "+ produto.getQuantidade());
            Glide.with(contexto)
                    .load("http://"+ SingletonParque.getIP() +":8081/imgs/" + produto.getImg())
                    .placeholder(R.drawable.es500x500)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgProduto);
        }

    }
}
