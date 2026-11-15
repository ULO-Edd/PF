package com.example.parkjoy.Models;

public class Topicos_Sugestoes {
    private int id;
    private String topico;

    public int getId() { return id; }

    public String getTopico() { return topico; }

    public void setTopico(String topico) {
        this.topico = topico;
    }

    public Topicos_Sugestoes(int id, String topico) {
        this.id = id;
        this.topico = topico;
    }
}

