package com.example.parkjoy.Models;

public class Produto {
        private int id;
        private int id_loja;
        private String descricao;
        private int quantidade;
        private int pontos;
        private String img;

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getIdLoja() {
        return id_loja;
    }

    public void setIdLoja(int id_loja) {
        this.id_loja = id_loja;
    }

    public String getDescricao() {
        return descricao;
    }

    public void setDescricao(String descricao) {
        this.descricao = descricao;
    }

    public int getQuantidade() {
        return quantidade;
    }

    public void setQuantidade(int quantidade) {
        this.quantidade = quantidade;
    }

    public int getPontos() {
        return pontos;
    }

    public void setPontos(int pontos) {
        this.pontos = pontos;
    }

    public String getImg() {
        return img;
    }

    public void setImg(String img) {
        this.img = img;
    }

    public Produto(int id, int id_loja, String descricao, int quantidade, int pontos, String img) {
        this.id = id;
        this.id_loja = id_loja;
        this.descricao = descricao;
        this.quantidade = quantidade;
        this.pontos = pontos;
        this.img = img;
    }
}
