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
import com.example.parkjoy.Models.News;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.R;

import java.util.ArrayList;

public class ListaNewsAdaptador extends BaseAdapter {

    private Context contexto;
    private LayoutInflater inflater;
    private ArrayList<News> news;

    public ListaNewsAdaptador(Context contexto, ArrayList<News> news) {
        this.contexto = contexto;
        this.news = news;
    }

    @Override
    public int getCount() {
        return news.size();
    }

    @Override
    public Object getItem(int i) {
        return news.get(i);
    }

    @Override
    public long getItemId(int i) {
        return news.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (inflater == null){
            inflater = (LayoutInflater) contexto.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (view == null){
            view = inflater.inflate(R.layout.activity_news, null);
        }

        ViewHolderLista viewHolderLista = (ViewHolderLista) view.getTag();
        if(viewHolderLista == null){
            viewHolderLista = new ViewHolderLista(view);
            view.setTag(viewHolderLista);
        }
        viewHolderLista.update(news.get(i));

        return view;
    }

    private class ViewHolderLista{
        private TextView tvTitulo, tvText;
        private ImageView imgNews;

        public ViewHolderLista(View view) {
            tvTitulo = view.findViewById(R.id.tv_title_news);
            tvText = view.findViewById(R.id.tv_text_news);
            imgNews = view.findViewById(R.id.iv_news);
        }

        public void update (News news){
            tvTitulo.setText(news.getTitulo());
            tvText.setText(news.getDescricao());
            Glide.with(contexto)
                    .load("http://"+ SingletonParque.getIP()+":8081/imgs/" + news.getImg())
                    .placeholder(R.drawable.es500x500)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgNews);
        }
    }
}
