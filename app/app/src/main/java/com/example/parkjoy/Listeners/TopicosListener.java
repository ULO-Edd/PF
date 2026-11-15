package com.example.parkjoy.Listeners;
import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.Topicos_Sugestoes;

import java.util.ArrayList;

public interface TopicosListener {
    void onRefreshTopicos(ArrayList<Topicos_Sugestoes> topicos);
}
