package com.example.parkjoy.Utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import com.example.parkjoy.Models.Activities;
import com.example.parkjoy.Models.Evento;
import com.example.parkjoy.Models.Loja;
import com.example.parkjoy.Models.News;
import com.example.parkjoy.Models.Pessoa;
import com.example.parkjoy.Models.Produto;
import com.example.parkjoy.Models.Ticket;
import com.example.parkjoy.Models.Topicos_Sugestoes;
import com.example.parkjoy.Models.User;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class ParkJsonParser {

    public static boolean isConnectionInternet(Context context){
        ConnectivityManager connectivityManager = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connectivityManager.getActiveNetworkInfo();

        return networkInfo != null && networkInfo.isConnected();
    }


    // -_-_-_-_-_-_-_-_-_-_-_-_-_-_N O V I D A D E S_-_-_-_-_-_-_-_-_-_-_-_-_-_-


    public static ArrayList<News> parserJsonNovidades(JSONArray response){
        ArrayList<News> novidades = new ArrayList<>();

        try {
            for (int i = 0; i <response.length(); i++){
                JSONObject jnews = (JSONObject)response.get(i);
                int idNews = jnews.getInt("id");
                String titulo = jnews.getString("titulo");
                String descricao = jnews.getString("descricao");
                String date_expire = jnews.getString("date_expire");
                String img = jnews.getString("image");

                News auxNews = new News(idNews, titulo, descricao, date_expire, img);
                novidades.add(auxNews);
            }
        } catch (JSONException e){
            e.printStackTrace();
        }


        return novidades;
    }

    public static News parserJsonNovidade(String response){

        News auxNews= null;

        try {
            JSONObject object = new JSONObject(response);
            JSONObject jnews = object.getJSONObject("Novidade");

            int idNews = jnews.getInt("id");
            String titulo = jnews.getString("titulo");
            String descricao = jnews.getString("descricao");
            String date_expire = jnews.getString("date_expire");
            String img = jnews.getString("image");

            auxNews = new News(idNews, titulo, descricao, date_expire, img);
        } catch (JSONException e){
            e.printStackTrace();
        }

        return auxNews;
    }


    // -_-_-_-_-_-_-_-_-_-_-_-_-_-_A T I V I D A D E S_-_-_-_-_-_-_-_-_-_-_-_-_-_-

    public static ArrayList<Activities> parserJsonAtividades(String response) {
        ArrayList<Activities> atividades = new ArrayList<>();

        try {
            JSONObject object = new JSONObject(response);
            JSONArray activities = object.getJSONArray("Atividades");


            for (int i = 0; i < activities.length(); i++){
                JSONObject jactivities = (JSONObject)activities.get(i);
                JSONObject jticketActivity = jactivities.getJSONObject("atividade");
                int idAtividade = jticketActivity.getInt("id");
                String tipoAtividade = jactivities.getString("tipo_atividade");
                String designacao = jticketActivity.getString("designacao");
                String descricao = jticketActivity.getString("descricao");
                int lotacao = jticketActivity.getInt("lotacao");
                String image = jticketActivity.getString("image");
                Activities auxActivity = new Activities(idAtividade, tipoAtividade, designacao, descricao, lotacao, image);
                atividades.add(auxActivity);
            }

        } catch (JSONException e){
            e.printStackTrace();
        }

        return atividades;
    }


    // -_-_-_-_-_-_-_-_-_-_-_-_-_-_P E S S O A_-_-_-_-_-_-_-_-_-_-_-_-_-_-

    public static Pessoa parserJsonPessoa(JSONObject response){
        Pessoa pessoa = null;

        try {
                JSONObject pessoaJSON = response.getJSONObject("pessoa");

                int idPessoa = pessoaJSON.getInt("id");
                String name = pessoaJSON.getString("name");
                String lastname = pessoaJSON.getString("lastname");
                int telephone = pessoaJSON.getInt("telephone");
                String birthday = pessoaJSON.getString("birthday_date");
                int points = pessoaJSON.getInt("points");

                pessoa = new Pessoa(idPessoa, name, lastname, birthday,""+telephone, points);
        } catch (JSONException e){
            e.printStackTrace();
        }

        return pessoa;
    }

    // -_-_-_-_-_-_-_-_-_-_-_-_-_-_U S E R_-_-_-_-_-_-_-_-_-_-_-_-_-_-

    public static User parserJsonUser(JSONObject response){
        User user = null;

        try {
            JSONObject pessoaJSON = response.getJSONObject("user");

            int idUser = pessoaJSON.getInt("id");
            String username = pessoaJSON.getString("username");
            String email = pessoaJSON.getString("email");


            user = new User(idUser, username, email);
        } catch (JSONException e){
            e.printStackTrace();
        }

        return user;
    }

    // -_-_-_-_-_-_-_-_-_-_-_-_-_-_TOPICOS SUGESTÂO_-_-_-_-_-_-_-_-_-_-_-_-_-_-


    public static ArrayList<Topicos_Sugestoes> parserJsonTopicos(JSONArray response){
        ArrayList<Topicos_Sugestoes> topicos = new ArrayList<>();
        try {
            for (int i = 0; i <response.length(); i++){
                JSONObject jtopicos = (JSONObject)response.get(i);
                int idTopico = jtopicos.getInt("id");
                String topico = jtopicos.getString("topico");

                Topicos_Sugestoes auxTopSug = new Topicos_Sugestoes(idTopico, topico);
                topicos.add(auxTopSug);
            }
        } catch (JSONException e){
            e.printStackTrace();
        }


        return topicos;
    }


        public static Topicos_Sugestoes parserJsonTopico(String response){

            Topicos_Sugestoes auxTopSug = null;
            try {
                JSONObject jtopicos = new JSONObject(response);

                int idTopico = jtopicos.getInt("id");
                String topico = jtopicos.getString("topico");

                auxTopSug = new Topicos_Sugestoes(idTopico, topico);
            } catch (JSONException e){
                e.printStackTrace();
            }

            return auxTopSug;
        }

    // -_-_-_-_-_-_-_-_-_-_-_-_-_-_T I C K E T S_-_-_-_-_-_-_-_-_-_-_-_-_-_-

    public static ArrayList<Ticket> parserJsonUserTickets(String response) {
        ArrayList<Ticket> tickets = new ArrayList<>();
        try {
            JSONObject object = new JSONObject(response);
            JSONArray ticket = object.getJSONArray("Ticket");

            for (int i = 0; i <ticket.length(); i++){
                JSONObject jtickets = (JSONObject) ticket.get(i);
                int idTicket = jtickets.getInt("id");
                int idPessoa = jtickets.getInt("id_pessoa");
                String dataDeCompra = jtickets.getString("data_de_compra");
                String dataDeUso = jtickets.getString("data_de_uso");
                int anulado = jtickets.getInt("anulado");
                int expirado = jtickets.getInt("expirado");
                int preCompra = jtickets.getInt("pre_compra");
                int preco = jtickets.getInt("preco");
                int numeroAtividades = jtickets.getInt("numero_atividades");

                if(anulado == 0 && expirado == 0 && preCompra == 0) {
                    Ticket auxTicket = new Ticket(idTicket, idPessoa, dataDeCompra, dataDeUso, anulado, expirado, preCompra, preco, numeroAtividades);
                    tickets.add(auxTicket);
                }
            }
        } catch (JSONException e){
            e.printStackTrace();
        }


        return tickets;
    }


    public static ArrayList<Activities> parserJsonTicketActivities(String response) {
        ArrayList<Activities> atividades = new ArrayList<>();

        try {
            JSONObject object = new JSONObject(response);
            JSONArray activities = object.getJSONArray("Atividades");


            for (int i = 0; i < activities.length(); i++){
                JSONObject jactivities = (JSONObject)activities.get(i);
                JSONObject jticketActivity = jactivities.getJSONObject("atividade");
                int idAtividade = jticketActivity.getInt("id");
                String tipoAtividade = jactivities.getString("tipo_atividade");
                String designacao = jticketActivity.getString("designacao");
                String descricao = jticketActivity.getString("descricao");
                int lotacao = jticketActivity.getInt("lotacao");
                String image = jticketActivity.getString("image");
                Activities auxActivity = new Activities(idAtividade, tipoAtividade, designacao, descricao, lotacao, image);
                atividades.add(auxActivity);
            }

        } catch (JSONException e){
            e.printStackTrace();
        }

        return atividades;
    }


    public static ArrayList<Activities> parserJsonUserFavorites(String response) {
        ArrayList<Activities> activities = new ArrayList<>();
        try {
            JSONObject object = new JSONObject(response);
            JSONArray atividades = object.getJSONArray("Favoritos");

            for (int i = 0; i <atividades.length(); i++){
                JSONObject atividadesObject = atividades.getJSONObject(i);
                JSONObject jfavorites = atividadesObject.getJSONObject("atividade");
                int idAtividade = jfavorites.getInt("id");
                String tipoAtividade = atividadesObject.getString("tipo_atividade");
                String designacao = jfavorites.getString("designacao");
                String descricao = jfavorites.getString("descricao");
                int lotacao = jfavorites.getInt("lotacao");
                String image = jfavorites.getString("image");

                Activities auxActivs = new Activities(idAtividade, tipoAtividade, designacao, descricao, lotacao, image);
                activities.add(auxActivs);
            }
        } catch (JSONException e){
            e.printStackTrace();
        }
        return activities;
    }

    // -_-_-_-_-_-_-_-_-_-_-_-_-_-_E V E N T O S-_-_-_-_-_-_-_-_-_-_-_-_-_-

    public static ArrayList<Evento> parserJsonEventos(JSONArray response){
        ArrayList<Evento> eventos = new ArrayList<>();
        try {
            for (int i = 0; i < response.length(); i++){
                JSONObject jEvento = (JSONObject)response.get(i);
                int idEvento = jEvento.getInt("id");
                String designacao = jEvento.getString("designacao");
                String descricao = jEvento.getString("descricao");
                String dataInicio = jEvento.getString("data_inicio");
                String dataConclusao = jEvento.getString("data_conclusao");
                int pontosParticipacao = jEvento.getInt("pontos_participacao");
                int ativo = jEvento.getInt("ativo");
                String image = jEvento.getString("image");

                Evento auxEvento = new Evento(idEvento, designacao, descricao, dataInicio, dataConclusao, pontosParticipacao, ativo, image);
                eventos.add(auxEvento);
            }

        } catch (JSONException e){
            e.printStackTrace();
        }


        return eventos;
    }

    public static Evento parserJsonEvento(String response){
        Evento evento = null;

        try {
            JSONObject object = new JSONObject(response);
            JSONObject eventoJSON = object.getJSONObject("Evento");

            int idEvento = eventoJSON.getInt("id");
            String designacao = eventoJSON.getString("designacao");
            String descricao = eventoJSON.getString("descricao");
            String dataInicio = eventoJSON.getString("data_inicio");
            String dataConclusao = eventoJSON.getString("data_conclusao");
            int pontosParticipacao = eventoJSON.getInt("pontos_participacao");
            int ativo = eventoJSON.getInt("ativo");
            String image = eventoJSON.getString("image");


            evento = new Evento(idEvento, designacao, descricao, dataInicio, dataConclusao, pontosParticipacao, ativo, image);
        } catch (JSONException e){
            e.printStackTrace();
        }

        return evento;
    }

    public static ArrayList<Activities> parserJsonEventosActivities(String response) {
        ArrayList<Activities> atividades = new ArrayList<>();

        try {
            JSONObject object = new JSONObject(response);
            JSONArray activities = object.getJSONArray("Atividades");


            for (int i = 0; i < activities.length(); i++){
                JSONObject jactivities = (JSONObject)activities.get(i);
                JSONObject jticketActivity = jactivities.getJSONObject("atividade");
                int idAtividade = jticketActivity.getInt("id");
                String tipoAtividade = jactivities.getString("tipo_atividade");
                String designacao = jticketActivity.getString("designacao");
                String descricao = jticketActivity.getString("descricao");
                int lotacao = jticketActivity.getInt("lotacao");
                String image = jticketActivity.getString("image");
                Activities auxActivity = new Activities(idAtividade, tipoAtividade, designacao, descricao, lotacao, image);
                atividades.add(auxActivity);
            }

        } catch (JSONException e){
            e.printStackTrace();
        }

        return atividades;
    }

    // -_-_-_-_-_-_-_-_-_-_-_-_-_-_L O J A-_-_-_-_-_-_-_-_-_-_-_-_-_-

    public static Loja parserJsonLoja(String response){
        Loja loja = null;
        try {
            JSONObject object = new JSONObject(response);
            JSONObject jloja = object.getJSONObject("Loja");

            int idLoja = jloja.getInt("id");
            String designacao = jloja.getString("designacao");

            loja = new Loja(idLoja, designacao);
        } catch (JSONException e){
            e.printStackTrace();
        }


        return loja;
    }

    public static ArrayList<Produto> parserJsonLojaProdutos(String response) {
        ArrayList<Produto> produtos = new ArrayList<>();

        try {
            JSONObject object = new JSONObject(response);
            JSONArray products = object.getJSONArray("Produtos");


            for (int i = 0; i < products.length(); i++){
                JSONObject jproducts = (JSONObject)products.get(i);
                JSONObject jproduct = jproducts.getJSONObject("produto");
                int idProduto = jproduct.getInt("id");
                int idLoja = jproduct.getInt("id_loja");
                String descricao = jproduct.getString("descricao");
                int quantidade = jproduct.getInt("quantidade");
                int points = jproduct.getInt("points");
                String image = jproduct.getString("image");
                Produto auxProduto = new Produto(idProduto, idLoja, descricao, quantidade, points, image);
                produtos.add(auxProduto);
            }

        } catch (JSONException e){
            e.printStackTrace();
        }

        return produtos;
    }
}
