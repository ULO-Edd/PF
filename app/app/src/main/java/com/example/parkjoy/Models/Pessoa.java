package com.example.parkjoy.Models;

public class Pessoa {
    private int id;
    private String nome;
    private String lastnome;
    private String telephone;
    private String birthday;
    private int points;

    public int getId() {
        return id;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getLastnome() {
        return lastnome;
    }

    public void setLastnome(String lastnome) {
        this.lastnome = lastnome;
    }

    public String getTelephone() {
        return telephone;
    }

    public void setTelephone(String telephone) {
        this.telephone = telephone;
    }

    public String getBirthday() {
        return birthday;
    }

    public void setBirthday(String birthday) {
        this.birthday = birthday;
    }

    public int getPoints() {
        return points;
    }

    public void setPoints(int points) {
        this.points = points;
    }

    public Pessoa(int id, String nome, String lastnome, String birthday, String telephone, int points) {
        this.id = id;
        this.nome = nome;
        this.lastnome = lastnome;
        this.birthday = birthday;
        this.telephone = telephone;
        this.points = points;
    }
}


