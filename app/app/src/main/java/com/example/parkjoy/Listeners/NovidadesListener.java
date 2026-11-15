package com.example.parkjoy.Listeners;

import com.example.parkjoy.Models.News;

import java.util.ArrayList;

public interface NovidadesListener {
    void onRefreshListaNews(ArrayList<News> news);

    void onRefreshNovidade();
}
