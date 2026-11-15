package com.example.parkjoy.Listeners;
import com.example.parkjoy.Models.Evento;
import com.example.parkjoy.Models.Produto;

import java.util.ArrayList;

public interface ProdutosListener {
    void onRefreshListaProdutos(ArrayList<Produto> produtos);
}
