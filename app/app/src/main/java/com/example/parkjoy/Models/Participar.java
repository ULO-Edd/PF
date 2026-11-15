package com.example.parkjoy.Models;

public class Participar {
    private int id_user;
    private int id_atividade;

    public int getId_user() {
        return id_user;
    }

    public void setId_user(int id_user) {
        this.id_user = id_user;
    }

    public int getId_atividade() {
        return id_atividade;
    }

    public void setId_atividade(int id_atividade) {
        this.id_atividade = id_atividade;
    }

    public Participar(int id_user, int id_atividade) {
        this.id_user = id_user;
        this.id_atividade = id_atividade;
    }
}
