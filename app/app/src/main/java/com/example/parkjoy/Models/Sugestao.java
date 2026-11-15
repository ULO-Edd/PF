package com.example.parkjoy.Models;

public class Sugestao {
    private String idUser;
    private String idTopico;
    private String contexto;

    public String getIdUser() {
        return idUser;
    }

    public void setIdUser(String idUser) {
        this.idUser = idUser;
    }

    public String getIdTopico() {
        return idTopico;
    }

    public void setIdTopico(String idTopico) {
        this.idTopico = idTopico;
    }

    public String getContexto() {
        return contexto;
    }

    public void setContexto(String contexto) {
        this.contexto = contexto;
    }

    public Sugestao(String idUser, String idTopico, String contexto) {
        this.idUser = idUser;
        this.idTopico = idTopico;
        this.contexto = contexto;
    }
}


