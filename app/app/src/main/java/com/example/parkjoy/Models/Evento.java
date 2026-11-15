package com.example.parkjoy.Models;

public class Evento {
    private int id;
    private String designacao;
    private String descricao;
    private String dataInicio;
    private String dataConclusao;
    private int pontosParticipacao;
    private int ativo;
    private String img;

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

    public String getDescricao() {
        return descricao;
    }

    public void setDescricao(String descricao) {
        this.descricao = descricao;
    }

    public String getDataInicio() {
        return dataInicio;
    }

    public void setDataInicio(String dataInicio) {
        this.dataInicio = dataInicio;
    }

    public String getDataConclusao() {
        return dataConclusao;
    }

    public void setDataConclusao(String dataConclusao) {
        this.dataConclusao = dataConclusao;
    }

    public int getPontosParticipacao() {
        return pontosParticipacao;
    }

    public void setPontosParticipacao(int pontosParticipacao) {
        this.pontosParticipacao = pontosParticipacao;
    }

    public int isAtivo() {
        return ativo;
    }

    public void setAtivo(int ativo) {
        this.ativo = ativo;
    }

    public String getImg() {
        return img;
    }

    public void setImg(String img) {
        this.img = img;
    }

    public Evento(int id, String designacao, String descricao, String dataInicio, String dataConclusao, int pontosParticipacao, int ativo, String img) {
        this.id = id;
        this.designacao = designacao;
        this.descricao = descricao;
        this.dataInicio = dataInicio;
        this.dataConclusao = dataConclusao;
        this.pontosParticipacao = pontosParticipacao;
        this.ativo = ativo;
        this.img = img;
    }
}
