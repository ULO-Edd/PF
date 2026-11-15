package com.example.parkjoy.Models;

import android.media.Image;
import android.widget.ImageView;

public class News {
    private int id;
    private String titulo;
    private String descricao;
    private String date_expire;
    private String img;

    public int getId() { return id; }


    public String getTitulo() { return titulo; }

    public void setTitulo(String titulo) { this.titulo = titulo; }

    public String getDescricao() {
        return descricao;
    }

    public void setDescricao(String descricao) {
        this.descricao = descricao;
    }

    public String getDateExpire() {
        return date_expire;
    }

    public void setDateExpire(String date_expire) {
        this.date_expire = date_expire;
    }

    public String getImg() {
        return img;
    }

    public void setImg(String img) {
        this.img = img;
    }

    public News(int id, String titulo, String descricao, String date_expire, String img) {

        this.titulo = titulo;
        this.descricao = descricao;
        this.date_expire = date_expire;
        this.img = img;
        this.id = id;
    }

    public int setId(int id) {
        return this.id = id; }
}