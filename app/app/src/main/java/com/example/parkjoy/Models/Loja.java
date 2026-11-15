package com.example.parkjoy.Models;

public class Loja {
    private int id;
    private String designacao;

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getDesignacao() {
        return designacao;
    }

    public void setDesignacao(String designacao) {
        this.designacao = designacao;
    }


    public Loja(int id, String designacao) {
        this.id = id;
        this.designacao = designacao;
    }
}
