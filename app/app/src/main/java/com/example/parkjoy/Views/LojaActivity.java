package com.example.parkjoy.Views;

import androidx.activity.result.ActivityResult;
import androidx.activity.result.ActivityResultCallback;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.appcompat.app.AppCompatActivity;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;


import com.example.parkjoy.Adaptador.ListaActivitiesAdaptador;
import com.example.parkjoy.Adaptador.ListaProdutosAdaptador;
import com.example.parkjoy.Listeners.ProdutoListener;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.Loja;
import com.example.parkjoy.Models.Pessoa;
import com.example.parkjoy.Models.Produto;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.R;

import java.util.ArrayList;

public class LojaActivity extends AppCompatActivity implements SwipeRefreshLayout.OnRefreshListener{

    private Loja loja;
    private Pessoa pessoa;
    private TextView tvLojaTitle, tvUserPoints;
    private ListView lvLojaProdutos;
    private SwipeRefreshLayout swipeRefreshLayout;
    private ActivityResultLauncher<Intent> activityResultLauncher;
    private ArrayList<Produto> produtos;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_loja);

        loja = SingletonParque.getInstance(getApplicationContext()).getLoja();
        pessoa = SingletonParque.getInstance(getApplicationContext()).parkBDHelper.getPessoaBD();


        tvLojaTitle = findViewById(R.id.tv_title_loja);
        tvUserPoints = findViewById(R.id.tv_user_points);

        activityResultLauncher = registerForActivityResult(new ActivityResultContracts.StartActivityForResult()
                , new ActivityResultCallback<ActivityResult>() {
                    @Override
                    public void onActivityResult(ActivityResult result) {

                    }
                });

        if (loja != null) {
            setTitle("Loja");
            tvLojaTitle.setText(loja.getDesignacao());
            tvUserPoints.setText("Pontos:" + pessoa.getPoints());
        }

        lvLojaProdutos = findViewById(R.id.lvLojaProdutos);
        swipeRefreshLayout = findViewById(R.id.swipe_refresh_layout_loja_produtos);
        swipeRefreshLayout.setOnRefreshListener(this);

        produtos = SingletonParque.getInstance(getApplicationContext()).getAllProdutosBD();


        if (produtos != null) {
            lvLojaProdutos.setAdapter(new ListaProdutosAdaptador(getApplicationContext(), produtos));

        }

        lvLojaProdutos.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                Intent intent = new Intent(getApplicationContext(), ProdutoDetailActivity.class);
                Produto product = (Produto) lvLojaProdutos.getItemAtPosition(i);
                intent.putExtra(ProdutoDetailActivity.ID_PRODUTO, product.getId());
                activityResultLauncher.launch(intent);
            }
        });
    }


    @Override
    public void onRefresh() {

    }
}