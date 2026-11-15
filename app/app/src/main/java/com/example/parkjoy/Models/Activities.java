package com.example.parkjoy.Models;

public class Activities {
    private int id;
    private String tipo_aitividade;
    private String designacao;
    private String descricao;
    private int lotacao;
    private String img;


    public int getId() { return id; }

    public String getTipoAtividade() { return tipo_aitividade; }

    public void setTipoAtividade(String TipoAtividade) { this.tipo_aitividade = TipoAtividade; }

    public String getDesignacao() {
        return designacao;
    }

    public void setDesignacao(String designacao) {
        this.designacao = designacao;
    }

    public String getDescricao() {
        return descricao;
    }

    public void setDescricao(String descricao) {
        this.descricao = descricao;
    }

    public int getLotacao() {
        return lotacao;
    }

    public void setLotacao(int lotacao) {
        this.lotacao = lotacao;
    }

    public void setImg(String img) {
        this.img = img;
    }

    public String getImg() {
        return img;
    }

    public Activities(int id, String tipo_aitividade, String designacao, String descricao, int lotacao, String img) {
        this.id = id;
        this.tipo_aitividade = tipo_aitividade;
        this.designacao = designacao;
        this.descricao = descricao;
        this.lotacao = lotacao;
        this.img = img;
    }
}


