package com.example.parkjoy.Models;

public class Ticket {

    private int id;
    private int id_pessoa;
    private String data_de_compra;
    private String data_de_uso;
    private int anulado;
    private int expirado;
    private int pre_compra;
    private int preco;
    private int numero_atividades;

    public int getId() { return id; }

    public int getIdPessoa() { return id_pessoa; }

    public String getDataDeCompra() {
        return data_de_compra;
    }

    public String setDataDeCompra(String data_de_compra) {
        return this.data_de_compra = data_de_compra;
    }

    public String getDataDeUso() {
        return data_de_uso;
    }

    public String setDataDeUso(String data_de_uso) {
        return this.data_de_uso = data_de_uso;
    }

    public int getAnulado() {
        return anulado;
    }

    public void setAnulado(int anulado) {
        this.anulado = anulado;
    }

    public int getExpirado() {
        return expirado;
    }

    public void setExpirado(int expirado) {
        this.expirado = expirado;
    }

    public int getPre_compra() {
        return pre_compra;
    }

    public void setPre_compra(int pre_compra) {
        this.pre_compra = pre_compra;
    }

    public int getPreco(){return preco;}

    public int getNumero_atividades() {
        return numero_atividades;
    }

    public void setNumero_atividades(int numero_atividades) {
        this.numero_atividades = numero_atividades;
    }

    public Ticket(int id, int id_pessoa, String data_de_compra, String data_de_uso, int anulado, int expirado, int pre_compra, int preco, int numero_atividades) {
        this.id = id;
        this.id_pessoa = id_pessoa;
        this.data_de_compra = data_de_compra;
        this.data_de_uso = data_de_uso;
        this.anulado = anulado;
        this.expirado = expirado;
        this.pre_compra = pre_compra;
        this.preco = preco;
        this.numero_atividades = numero_atividades;
    }
}