package com.example.parkjoy;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.parkjoy.Listeners.EventoListener;
import com.example.parkjoy.Listeners.NovidadeListener;
import com.example.parkjoy.Listeners.ProdutoListener;
import com.example.parkjoy.Listeners.ProdutosListener;
import com.example.parkjoy.Models.Evento;
import com.example.parkjoy.Models.News;
import com.example.parkjoy.Models.Produto;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Views.AboutActivity;
import com.example.parkjoy.Views.ActivityListaFragment;
import com.example.parkjoy.Views.EventosListaFragment;
import com.example.parkjoy.Views.FavoritesListaFragment;
import com.example.parkjoy.Views.LoginActivity;
import com.example.parkjoy.Views.LojaActivity;
import com.example.parkjoy.Views.MyInfoActivity;
import com.example.parkjoy.Views.NewsListaFragment;
import com.example.parkjoy.Views.ReportFragment;
import com.example.parkjoy.Views.TicketListaFragment;
import com.google.android.material.navigation.NavigationView;

import java.util.ArrayList;
import java.util.Timer;
import java.util.TimerTask;

public class MainActivity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener, NovidadeListener, EventoListener, ProdutosListener {

    public static final String EMAIL = "userDenomination";
    private String email;
    private Evento evento;
    private News news;

    private NavigationView navigationView;
    private DrawerLayout drawer;
    private FragmentManager fragmentManager;
    private ImageView eventImage, newsImage;
    private TextView eventTitle, eventDescription, newsTitle, newsDescription;
    private Intent pendingIntent = null;

    public static final int ADD = 100, EDIT = 200, DEL = 300;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        drawer = findViewById(R.id.drawerLayout);
        navigationView = findViewById(R.id.navView);
        eventImage = findViewById(R.id.iv_latest_event);
        newsImage = findViewById(R.id.iv_latest_news);
        eventTitle = findViewById(R.id.tv_latest_title_event);
        newsTitle = findViewById(R.id.tv_latest_title_news);
        eventDescription = findViewById(R.id.tv_latest_text_event);
        newsDescription = findViewById(R.id.tv_latest_text_news);

        evento = SingletonParque.getInstance(getApplicationContext()).getLatestEvent();
        news = SingletonParque.getInstance(getApplicationContext()).getLatestNews();

        if(evento != null && news != null){
            CarregarEvento();
            CarregarNovidade();
        }

        SingletonParque.getInstance(getApplicationContext()).setEventoListener(this);
        SingletonParque.getInstance(getApplicationContext()).setNovidadeListener(this);
        SingletonParque.getInstance(getApplicationContext()).setProdutosListener(this);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(this, drawer, toolbar, R.string.ndOpen, R.string.ndClose);
        toggle.syncState();

        drawer.addDrawerListener(toggle);
        navigationView.setNavigationItemSelectedListener(this);
        fragmentManager = getSupportFragmentManager();

        loadHeader();
        //loadInitialFragment();
    }


    private void loadHeader() {
        email = getIntent().getStringExtra(EMAIL);
        if (email != null) {
            View view = navigationView.getHeaderView(0);
            TextView tvEmail = view.findViewById(R.id.tv_emailHeader);

            tvEmail.setText(email);
        }

    }

    private boolean loadInitialFragment() {
        Menu menu = navigationView.getMenu();
        MenuItem item = menu.getItem(3);
        item.setCheckable(true);
        return onNavigationItemSelected(item);
    }

    public void logout() {
        SingletonParque.getInstance(getApplicationContext()).parkBDHelper.removerPessoaBD();
        SingletonParque.getInstance(getApplicationContext()).parkBDHelper.removerUserBD();

        Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
        startActivity(intent);
        finish();
    }

    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem item) {
        Fragment fragment = null;
        switch (item.getItemId()) {
            case R.id.navPrincipal: {
                System.out.println("-->NavPrincipal");
                Intent intent = new Intent(getApplicationContext(), MainActivity.class);
                pendingIntent = intent;
                SingletonParque.getInstance(getApplicationContext()).getEvent(getApplicationContext());
                SingletonParque.getInstance(getApplicationContext()).getNovidade(getApplicationContext());
                break;
            }
            case R.id.navAboutMe:{
                System.out.println("-->NavAboutMe");
                Intent intent = new Intent(getApplicationContext(), MyInfoActivity.class);
                startActivity(intent);
                break;
            }
            case R.id.navNews: {
                System.out.println("-->NavNews");
                fragment = new NewsListaFragment();
            }
            break;
            case R.id.navAtv: {
                System.out.println("-->NavAtv");
                fragment = new ActivityListaFragment();
            }
            break;
            case R.id.navFav: {
                System.out.println("-->NavFav");
                fragment = new FavoritesListaFragment();
            }
            break;
            case R.id.navEventos: {
                System.out.println("-->NavEventos");
                fragment = new EventosListaFragment();
            }
            break;
            case R.id.navLoja: {
                System.out.println("-->NavLoja");
                Intent intent = new Intent(getApplicationContext(), LojaActivity.class);
                pendingIntent = intent;
                SingletonParque.getInstance(getApplicationContext()).getLojaAndAllProdutosAPI(getApplicationContext());
            }
            break;
            case R.id.navAbout: {
                System.out.println("-->NavAbout");
                Intent intent = new Intent(getApplicationContext(), AboutActivity.class);
                startActivity(intent);
            }
            break;
            case R.id.navReports: {
                System.out.println("-->NavReports");
                fragment = new ReportFragment();
            }
            break;
            case R.id.navLogout:
                System.out.println("-->NavLogout");
                logout();
                break;

        }

        if (fragment != null) {
            fragmentManager.beginTransaction().replace(R.id.contentFragment, fragment).commit();
        }

        drawer.closeDrawer(GravityCompat.START);
        return true;

    }


    public void OnClickSeeTickets(View view){
        Fragment fragment;
        fragment = new TicketListaFragment();
        fragmentManager.beginTransaction().replace(R.id.contentFragment, fragment).commit();
    }


    private void CarregarEvento(){
        eventTitle.setText(evento.getDesignacao());
        eventDescription.setText(evento.getDescricao());

        Glide.with(getApplicationContext())
                .load("http://"+ SingletonParque.getIP() +":8081/imgs/" + evento.getImg())
                .placeholder(R.drawable.es500x500)
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .into(eventImage);

    }

    private void CarregarNovidade(){
        newsTitle.setText(news.getTitulo());
        newsDescription.setText(news.getDescricao());

        Glide.with(getApplicationContext())
                .load("http://"+ SingletonParque.getIP() +":8081/imgs/" + news.getImg())
                .placeholder(R.drawable.es500x500)
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .into(newsImage);

    }

    @Override
    public void onRefreshEvento(int op) {
        //MANTER VAZIO
    }

    @Override
    public void onRefreshNovidade(int op) {
        if(pendingIntent != null) {
            startActivity(pendingIntent);
        }
        pendingIntent = null;
    }

    @Override
    public void onRefreshListaProdutos(ArrayList<Produto> produtos) {
        if(pendingIntent != null) {
            startActivity(pendingIntent);
        }
        pendingIntent = null;
    }
}