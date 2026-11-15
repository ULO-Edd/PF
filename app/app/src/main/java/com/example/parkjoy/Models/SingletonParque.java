package com.example.parkjoy.Models;

import android.content.Context;
import android.util.Base64;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;

import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.parkjoy.Listeners.ActivitiesListener;
import com.example.parkjoy.Listeners.ActivityListener;
import com.example.parkjoy.Listeners.EventoListener;
import com.example.parkjoy.Listeners.EventosListener;
import com.example.parkjoy.Listeners.FavoriteListener;
import com.example.parkjoy.Listeners.FavoritesListener;
import com.example.parkjoy.Listeners.NovidadeListener;
import com.example.parkjoy.Listeners.NovidadesListener;


import com.example.parkjoy.Listeners.ProdutoListener;
import com.example.parkjoy.Listeners.ProdutosListener;
import com.example.parkjoy.Listeners.TicketListener;
import com.example.parkjoy.Listeners.TicketsListener;
import com.example.parkjoy.Listeners.TopicoListener;
import com.example.parkjoy.Listeners.TopicosListener;
import com.example.parkjoy.MainActivity;
import com.example.parkjoy.Utils.ParkJsonParser;

import org.eclipse.paho.android.service.MqttAndroidClient;
import org.eclipse.paho.client.mqttv3.IMqttActionListener;
import org.eclipse.paho.client.mqttv3.IMqttToken;
import org.eclipse.paho.client.mqttv3.MqttClient;
import org.eclipse.paho.client.mqttv3.MqttConnectOptions;
import org.eclipse.paho.client.mqttv3.MqttException;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class SingletonParque {

    private static final String TOKEN = "PARK_JOY-TOKEN";
    private ArrayList<News> news;
    private ArrayList<Activities> activities;
    private ArrayList<Topicos_Sugestoes> topicos;
    private ArrayList<Ticket> tickets;
    private ArrayList<Evento> eventos;
    private Loja loja;
    private ArrayList<Produto> produtos;
    private static SingletonParque instance = null;
    private static RequestQueue volleyQueue = null;
    public ParkBDHelper parkBDHelper = null;
    private MqttAndroidClient client = null;
    public static String IP = null;
    private static String urlAPILoja = "http://"+IP+":8081/v1/lojas";
    private static String urlAPIProdutos = "http://"+IP+":8081/v1/lojas/produtos";
    private static String urlAPIEventos = "http://"+IP+":8081/v1/eventos";
    private static String urlAPINews = "http://"+IP+":8081/v1/novidades";
    private static String urlAPITopicos = "http://"+IP+":8081/v1/topico-reports";
    private static String urlAPISugestoes = "http://"+IP+":8081/v1/reports";
    private static String urlAPILogin = "http://"+IP+":8081/v1/auths";
    private static String urlAPIUsers = "http://"+IP+":8081/v1/users";
    private static String urlAPITickets = "http://"+IP+":8081/v1/tickets";
    private static String urlAPIRegister = "http://"+IP+":8081/v1/users/register";
    private static String urlAPIAtividades = "http://"+IP+":8081/v1/atividades";

    // -> L I S T E N E R S <-s
    private NovidadeListener novidadeListener;
    public NovidadesListener novidadesListener;
    private FavoriteListener favoriteListener;
    private FavoritesListener favoritesListener;
    private ActivityListener activityListener;
    private ActivitiesListener activitiesListener;
    private TopicoListener topicoListener;
    private TopicosListener topicosListener;
    private TicketListener ticketListener;
    private TicketsListener ticketsListener;
    private EventosListener eventosListener;
    private EventoListener eventoListener;
    private ProdutosListener produtosListener;
    private ProdutoListener produtoListener;



    public static synchronized SingletonParque getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonParque(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return instance;
    }

    public SingletonParque(Context context) {
        news = new ArrayList<>();
        topicos = new ArrayList<>();
        activities = new ArrayList<>();
        parkBDHelper = new ParkBDHelper(context);

        client = new MqttAndroidClient(context, "tcp://broker.emqx.io:1883", MqttClient.generateClientId());
        client.setCallback(new MosquittoCallBack(context));

        MqttConnectOptions mqttConnectOptions = new MqttConnectOptions();
        mqttConnectOptions.setCleanSession(true);

        try {
            client.connect(mqttConnectOptions, null, new IMqttActionListener() {
                @Override
                public void onSuccess(IMqttToken asyncActionToken) {
                    try {
                        client.subscribe("INSERT", 1);
                        client.subscribe("UPDATE", 1);
                        client.subscribe("DELETE", 1);
                    } catch (MqttException e) {
                        e.printStackTrace();
                    }
                }

                @Override
                public void onFailure(IMqttToken asyncActionToken, Throwable exception) {
                    System.out.println("-->erro:");
                }
            });

        } catch (MqttException e) {
            e.printStackTrace();
        }

    }

    public static String getIP() {
        return IP;
    }

    public static void setIP(String IP) {
        SingletonParque.IP = IP;
        urlAPILoja = "http://"+IP+":8081/v1/lojas";
        urlAPIProdutos = "http://"+IP+":8081/v1/lojas/produtos";
        urlAPIEventos = "http://"+IP+":8081/v1/eventos";
        urlAPINews = "http://"+IP+":8081/v1/novidades";
        urlAPITopicos = "http://"+IP+":8081/v1/topico-reports";
        urlAPISugestoes = "http://"+IP+":8081/v1/reports";
        urlAPILogin = "http://"+IP+":8081/v1/auths";
        urlAPIUsers = "http://"+IP+":8081/v1/users";
        urlAPITickets = "http://"+IP+":8081/v1/tickets";
        urlAPIRegister = "http://"+IP+":8081/v1/users/register";
        urlAPIAtividades = "http://"+IP+":8081/v1/atividades";
    }

    public void setNovidadeListener(NovidadeListener newsListener) {
        this.novidadeListener = newsListener;
    }

    public void setNovidadesListener(NovidadesListener newssListener) {
        this.novidadesListener = newssListener;
    }

    public void setFavoriteListener(FavoriteListener favoriteListener) {
        this.favoriteListener = favoriteListener;
    }

    public void setFavoritesListener(FavoritesListener favoritesListener) {
        this.favoritesListener = favoritesListener;
    }

    public void setActivityListener(ActivityListener activityListener) {
        this.activityListener = activityListener;
    }

    public void setActivitiesListener(ActivitiesListener activitiesListener) {
        this.activitiesListener = activitiesListener;
    }

    public void setTopicoListener(TopicoListener topicoListener) {
        this.topicoListener = topicoListener;
    }

    public void setTopicosListener(TopicosListener topicosListener) {
        this.topicosListener = topicosListener;
    }

    public void setTicketListener(TicketListener ticketListener) {
        this.ticketListener = ticketListener;
    }

    public void setTicketsListener(TicketsListener ticketsListener) {
        this.ticketsListener = ticketsListener;
    }

    public void setEventosListener(EventosListener eventosListener) {
        this.eventosListener = eventosListener;
    }

    public void setEventoListener(EventoListener eventoListener) {
        this.eventoListener = eventoListener;
    }

    public void setProdutosListener(ProdutosListener produtosListener) {
        this.produtosListener = produtosListener;
    }

    public void setProdutoListener(ProdutoListener produtoListener) {
        this.produtoListener = produtoListener;
    }


    public ArrayList<News> getNovidades() {
        return new ArrayList<>(news);
    }

    public News getNovidade(int id) {

        for (News n : news) {
            if (n.getId() == id) {
                return n;
            }
        }

        return null;
    }


    public void adicionarNovidadeBD(News novidade) {

        parkBDHelper.adicionarNoticiasBD(novidade);

    }

    public void adicionarNovidadesBD(ArrayList<News> novidades) {

        parkBDHelper.removerAllNoticiasBD();
        for (News n : novidades) {
            adicionarNovidadeBD(n);
        }
    }

    public ArrayList<News> getAllnovidadesBD() {
        news = parkBDHelper.getAllNoticiasBD();
        return news;
    }

    public ArrayList<Activities> getActivities() {
        return new ArrayList<>(activities);
    }

    public Activities getActivity(int id) {

        for (Activities n : activities) {
            if (n.getId() == id) {
                return n;
            }
        }

        return null;
    }

    public void adicionarAtividadeBD(Activities act) {

        parkBDHelper.adicionarAtividadesBD(act);

    }

    public void adicionarAtividadesBD(ArrayList<Activities> acts) {

        parkBDHelper.removerAllAtividadesBD();
        for (Activities act : acts) {
            adicionarAtividadeBD(act);
        }
    }

    public ArrayList<Activities> getAllAtividadesBD() {
        activities = parkBDHelper.getAllAtividadesBD();
        return activities;
    }

    public ArrayList<Topicos_Sugestoes> getTopicos() {
        return new ArrayList<>(topicos);
    }

    public Topicos_Sugestoes getTopico(int id) {

        for (Topicos_Sugestoes ts : topicos) {
            if (ts.getId() == id) {
                return ts;
            }
        }

        return null;
    }


    public void adicionarTopicoBD(Topicos_Sugestoes topico) {

        parkBDHelper.adicionarTopicosBD(topico);

    }

    public void adicionarTopicosBD(ArrayList<Topicos_Sugestoes> topicos) {

        parkBDHelper.removerAllTopicosBD();
        for (Topicos_Sugestoes ts : topicos) {
            adicionarTopicoBD(ts);
        }
    }

    public ArrayList<Topicos_Sugestoes> getAllTopicosBD() {
        topicos = parkBDHelper.getAllTopicosBD();
        return topicos;
    }


    public ArrayList<Ticket> getTickets() {
        return new ArrayList<>(tickets);
    }

    public Ticket getTickets(int id) {

        for (Ticket t : tickets) {
            if (t.getId() == id) {
                return t;
            }
        }

        return null;
    }

    public void adicionarTicketBD(Ticket ticket) {

        parkBDHelper.adicionarTicketsBD(ticket);

    }

    public void adicionarTicketsBD(ArrayList<Ticket> tickets) {

        parkBDHelper.removerAllTicketsBD();
        for (Ticket tick : tickets) {
            adicionarTicketBD(tick);
        }
    }

    public ArrayList<Ticket> getAllTicketsBD() {
        tickets = parkBDHelper.getAllTicketsBD();
        return tickets;
    }

    public int getUserId() {
        User user = parkBDHelper.getUserBD();
        return user.getId();
    }

    public ArrayList<Evento> getEventos() {
        return new ArrayList<>(eventos);
    }

    public Evento getEvento(int id) {

        for (Evento e : eventos) {
            if (e.getId() == id) {
                return e;
            }
        }

        return null;
    }

    public void adicionarEventoBD(Evento evento) {

        parkBDHelper.adicionarEventosBD(evento);

    }

    public void adicionarEventosBD(ArrayList<Evento> eventos) {

        parkBDHelper.removerAllEventosBD();
        for (Evento eve : eventos) {
            adicionarEventoBD(eve);
        }
    }

    public ArrayList<Evento> getAllEventosBD() {
        eventos = parkBDHelper.getAllEventosBD();
        return eventos;
    }

    public Loja getLoja() {
        return loja;
    }

    public void adicionarLojaBD(Loja loja) {
        parkBDHelper.removerLojaBD();
        parkBDHelper.adicionarLojaBD(loja);
    }


    public ArrayList<Produto> getProdutos() {
        return new ArrayList<>(produtos);
    }

    public Produto getProduto(int id) {

        for (Produto p : produtos) {
            if (p.getId() == id) {
                return p;
            }
        }

        return null;
    }

    public void adicionarProdutoBD(Produto produto) {

        parkBDHelper.adicionarProdutosBD(produto);

    }

    public void adicionarProdutosBD(ArrayList<Produto> produtos) {

        parkBDHelper.removerAllProdutosBD();
        for (Produto pdc : produtos) {
            adicionarProdutoBD(pdc);
        }
    }

    public ArrayList<Produto> getAllProdutosBD() {
        produtos = parkBDHelper.getAllLojaProdutosBD();
        return produtos;
    }


    public Evento getLatestEvent() {
        return parkBDHelper.getLatestEventBD();
    }

    public News getLatestNews() {
        return parkBDHelper.getLatestNewsBD();
    }

    // -_-_-_-_-_-_-_-_-_-_-_-_-_-_A P I_-_-_-_-_-_-_-_-_-_-_-_-_-_-

    public void getAllNovidadesAPI(final Context context) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();

            //Listener BD Local
            if (novidadesListener != null) {
                novidadesListener.onRefreshListaNews(parkBDHelper.getAllNoticiasBD());
            }

        } else {
            JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, urlAPINews, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    System.out.println("---->"+IP);
                    news = ParkJsonParser.parserJsonNovidades(response);
                    adicionarNovidadesBD(news);

                    if (novidadesListener != null) {
                        novidadesListener.onRefreshListaNews(news);
                    }

                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_SHORT).show();
                    System.out.println("-->" + error.getMessage());
                }
            });
            volleyQueue.add(request);
        }
    }

    public void getAllTicketActivitiesAPI(Context context, int id) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();

        } else {
            StringRequest request = new StringRequest(Request.Method.GET, urlAPITickets + "/" + id + "/atividades", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    activities = ParkJsonParser.parserJsonTicketActivities(response);
                    adicionarAtividadesBD(activities);

                    if (activitiesListener != null) {
                        activitiesListener.onRefreshListaActivities(activities);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    System.out.println("-->" + error.getMessage());
                }
            });
            volleyQueue.add(request);
        }
    }

    public void getAllTopicosAPI(final Context context) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();

            //Listener BD Local
            if (topicosListener != null) {
                topicosListener.onRefreshTopicos(parkBDHelper.getAllTopicosBD());
            }

        } else {
            JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, urlAPITopicos, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    System.out.println("---->"+IP);
                    topicos = ParkJsonParser.parserJsonTopicos(response);
                    adicionarTopicosBD(topicos);

                    if (topicosListener != null) {
                        topicosListener.onRefreshTopicos(topicos);
                    }

                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_SHORT).show();
                    System.out.println("-->" + error.getMessage());
                }
            });
            volleyQueue.add(request);
        }
    }


    public void sendReportAPI(final Sugestao sugestao, final Context context) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();
        } else {
            StringRequest request = new StringRequest(Request.Method.POST, urlAPISugestoes, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    System.out.println("---->"+IP);
                    Toast toast = Toast.makeText(context, "Enviado com sucesso", Toast.LENGTH_LONG);
                    toast.show();
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_SHORT).show();
                    System.out.println("-->" + error.getMessage());
                }
            }) {
                @Override
                protected Map<String, String> getParams()
                {
                    Map<String, String> params = new HashMap<>();
                    params.put("id_user", sugestao.getIdUser());
                    params.put("id_topico", sugestao.getIdTopico());
                    params.put("descricao", sugestao.getContexto());
                    return params;
                }
            };
            volleyQueue.add(request);
        }
    }

    public void loginUserAPI(final Context context, String username, String password, Response.Listener onResponse, Response.ErrorListener onError) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não possui ligação á rede", Toast.LENGTH_SHORT).show();
            return;
        }
        JsonObjectRequest request = new JsonObjectRequest(Request.Method.GET, urlAPILogin + "?username=" + username + "&password=" + password, null, onResponse, onError)
        {
            protected Map<String, String> getParams() throws AuthFailureError {
                System.out.println("---->"+IP);
                HashMap<String, String> hashMap = new HashMap<String, String>();
                hashMap.put("username", username);
                hashMap.put("password", password);

                return hashMap;
            }

            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {

                HashMap<String, String> headers = new HashMap<String, String>();
                headers.put("Content-Type", "application/json");
                headers.put(
                        "Authorization",
                        String.format("Basic %s", Base64.encodeToString(
                                String.format("%s:%s", username, password).getBytes(), Base64.DEFAULT)));

                return headers;
            }
        };
        volleyQueue.add(request);
    }
    public void registerUserAPI(final Context context,final String username,final String nome,final String apelido,final String dateNascimento,final String email,final String password,final int telephone, Response.Listener onResponse, Response.ErrorListener onError) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não possui ligação á rede", Toast.LENGTH_SHORT).show();
            return;
        }
        JSONObject jsonobject = new JSONObject();
        try {
            jsonobject.put("username", username);
            jsonobject.put("email", email);
            jsonobject.put("password", password);
            jsonobject.put("name", nome);
            jsonobject.put("lastname", apelido);
            jsonobject.put("birthday_date", dateNascimento);
            jsonobject.put("telephone", "+351"+telephone);
        } catch (JSONException e) {
            e.printStackTrace();
        }
        JsonObjectRequest request = new JsonObjectRequest(Request.Method.POST, urlAPIRegister, jsonobject,onResponse, onError);

        volleyQueue.add(request);
    }

    public void getAllUserTicketsAPI(final Context context, int id) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();

        } else {
            StringRequest request = new StringRequest(Request.Method.GET, urlAPIUsers+ "/" + id + "/tickets", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    tickets = ParkJsonParser.parserJsonUserTickets(response);
                    adicionarTicketsBD(tickets);


                    if (ticketsListener != null) {
                        ticketsListener.onRefreshTickets(tickets);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    System.out.println("-->" + error.getMessage());
                }
            });
            volleyQueue.add(request);
        }
    }

    public void removerTicketAPI(final int id, final Context context){
        if (!ParkJsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação á rede", Toast.LENGTH_SHORT).show();

            //Listener BD Local
        }
        else {
            JsonObjectRequest request = new JsonObjectRequest(Request.Method.DELETE, urlAPITickets + "/" + id + "/remove",null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    if (ticketListener != null){
                        ticketListener.onRefreshDetalhes(MainActivity.DEL);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                }
            });
            volleyQueue.add(request);
        }
    }

    public void getAllUserFavoritesAPI(final Context context, int id) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();

        } else {
            StringRequest request = new StringRequest(Request.Method.GET, urlAPIUsers + "/" + id + "/favoritos", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    User user = parkBDHelper.getUserBD();
                    activities = ParkJsonParser.parserJsonUserFavorites(response);
                    adicionarAtividadesBD(activities);
                    parkBDHelper.removerFavoritoBD();
                    for (Activities activity: activities) {
                        parkBDHelper.adicionarFavoritoBD(user.getId(), activity.getId());
                    }


                    if (activitiesListener != null) {
                        activitiesListener.onRefreshListaActivities(activities);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    System.out.println("-->" + error.getMessage());
                }
            });
            volleyQueue.add(request);
        }
    }

    public void getOnlyUserFavoritesAPI(final Context context, int id) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();

        } else {
            StringRequest request = new StringRequest(Request.Method.GET, urlAPIUsers + "/" + id + "/favoritos", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    User user = parkBDHelper.getUserBD();
                    activities = ParkJsonParser.parserJsonUserFavorites(response);
                    parkBDHelper.removerFavoritoBD();
                    for (Activities activity: activities) {
                        parkBDHelper.adicionarFavoritoBD(user.getId(), activity.getId());
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    System.out.println("-->" + error.getMessage());
                }
            });
            volleyQueue.add(request);
        }
    }

    public void modifyUserAPI(Context context,int id_user, String newUsername, String newEmail, int newTelephone, Response.Listener onResponse, Response.ErrorListener onError) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não possui ligação á rede", Toast.LENGTH_SHORT).show();
            return;
        }
        JSONObject jsonObject = new JSONObject();
        try {
            jsonObject.put("id", id_user+"");
            jsonObject.put("username", newUsername);
            jsonObject.put("email", newEmail);
            jsonObject.put("telephone", "+351"+newTelephone);
        } catch (JSONException e) {
            e.printStackTrace();
        }

        JsonObjectRequest request = new JsonObjectRequest(Request.Method.PUT, urlAPIUsers+"/modify/" + id_user, jsonObject, onResponse, onError);

        volleyQueue.add(request);
    }

    public void getUserAPI(final Context context, int id) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();

        } else {
            JsonObjectRequest request = new JsonObjectRequest(Request.Method.GET, urlAPIUsers + "/get/" + id, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    User user = ParkJsonParser.parserJsonUser(response);
                    Pessoa pessoa = ParkJsonParser.parserJsonPessoa(response);

                    SingletonParque.getInstance(context).parkBDHelper.removerUserBD();
                    SingletonParque.getInstance(context).parkBDHelper.removerPessoaBD();

                    SingletonParque.getInstance(context).parkBDHelper.adicionarUserBD(user);
                    SingletonParque.getInstance(context).parkBDHelper.adicionarPessoaBD(pessoa);
                }

            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_SHORT).show();
                }
            });
            volleyQueue.add(request);
        }
    }

    public void addFavoritoAPI(final int id_user,final int id_atividade, final Context context, Response.Listener onResponse, Response.ErrorListener onError){
        if (!ParkJsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação á rede", Toast.LENGTH_SHORT).show();

            //Listener BD Local
        }
        else {
            JsonObjectRequest request = new JsonObjectRequest(Request.Method.POST, urlAPIUsers + "/" + id_user +  "/addfav/" + id_atividade, null, onResponse, onError);

            volleyQueue.add(request);
        }
    }


    public void delFavoritoAPI(final int id_user,final int id_atividade, final Context context, Response.Listener onResponse, Response.ErrorListener onError){
        if (!ParkJsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação á rede", Toast.LENGTH_SHORT).show();

            //Listener BD Local
        }
        else {
            JsonObjectRequest request = new JsonObjectRequest(Request.Method.DELETE, urlAPIUsers + "/" + id_user +  "/removefav/" + id_atividade, null, onResponse, onError);

            volleyQueue.add(request);
        }
    }

    public void addParticipacaoAPI(final int id_user,final int id_atividade, final Context context, Response.Listener onResponse, Response.ErrorListener onError){
        if (!ParkJsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação á rede", Toast.LENGTH_SHORT).show();

            //Listener BD Local
        }
        else {
            JsonObjectRequest request = new JsonObjectRequest(Request.Method.GET, urlAPIUsers + "/participar?id_user=" + id_user + "&id_atividade=" + id_atividade, null, onResponse, onError)
            {
                @Override
                protected Map<String, String> getParams()
                {
                    Map<String, String> params = new HashMap<>();
                    params.put("id_user", id_user+"");
                    params.put("id_atividade", id_atividade+"");
                    return params;
                }
            };
            volleyQueue.add(request);
        }
    }


    public void delParticipacaoAPI(final int id_user,final int id_atividade, final Context context, Response.Listener onResponse, Response.ErrorListener onError){
        if (!ParkJsonParser.isConnectionInternet(context)){
            Toast.makeText(context, "Não tem ligação á rede", Toast.LENGTH_SHORT).show();

            //Listener BD Local
        }
        else {
            JsonObjectRequest request = new JsonObjectRequest(Request.Method.GET, urlAPIUsers + "/desparticipar?id_user=" + id_user + "&id_atividade=" + id_atividade, null, onResponse, onError);

            volleyQueue.add(request);
        }
    }

    public void getEvent(final Context context) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();

        } else {
            StringRequest request = new StringRequest(Request.Method.GET, urlAPIEventos + "/latest", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Evento evento = ParkJsonParser.parserJsonEvento(response);

                    parkBDHelper.removerAllEventosBD();

                    adicionarEventoBD(evento);

                    if (eventoListener != null) {
                        eventoListener.onRefreshEvento(evento.getId());
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    System.out.println("-->" + error.getMessage());
                }
            });
            volleyQueue.add(request);
        }
    }

    public void getNovidade(final Context context) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();

        } else {
            StringRequest request = new StringRequest(Request.Method.GET, urlAPINews + "/latest", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    News novidade = ParkJsonParser.parserJsonNovidade(response);

                    parkBDHelper.removerAllNoticiasBD();

                    adicionarNovidadeBD(novidade);

                    if (novidadeListener != null) {
                        novidadeListener.onRefreshNovidade(novidade.getId());
                    }
                }

            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_SHORT).show();
                }
            });
            volleyQueue.add(request);
        }
    }

    public void getAllEventActivitiesAPI(final Context context, final int id) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();

        } else {
            StringRequest request = new StringRequest(Request.Method.GET, urlAPIEventos + "/" + id + "/atividades", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    activities = ParkJsonParser.parserJsonEventosActivities(response);
                    adicionarAtividadesBD(activities);


                    if (activitiesListener != null) {
                        activitiesListener.onRefreshListaActivities(activities);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    System.out.println("-->" + error.getMessage());
                }
            });
            volleyQueue.add(request);
        }
    }

    public void getAllEventosAPI(final Context context) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();

            //Listener BD Local
            if (eventosListener != null) {
                eventosListener.onRefreshListaEventos(parkBDHelper.getAllEventosBD());
            }

        } else {
            JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, urlAPIEventos , null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    System.out.println("---->"+IP);
                    eventos = ParkJsonParser.parserJsonEventos(response);
                    adicionarEventosBD(eventos);

                    if (eventosListener != null) {
                        eventosListener.onRefreshListaEventos(eventos);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    System.out.println("-->" + error.getMessage());
                }
            });
            volleyQueue.add(request);
        }
    }

    public void getLojaAndAllProdutosAPI(final Context context) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();

        } else {
            StringRequest request = new StringRequest(Request.Method.GET, urlAPIProdutos, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    loja = ParkJsonParser.parserJsonLoja(response);
                    produtos = ParkJsonParser.parserJsonLojaProdutos(response);
                    adicionarLojaBD(loja);
                    adicionarProdutosBD(produtos);


                    if (produtosListener != null) {
                        produtosListener.onRefreshListaProdutos(produtos);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    System.out.println("-->" + error.getMessage());
                }
            });
            volleyQueue.add(request);
        }
    }

    public void getAllAtividadesAPI(final Context context) {
        if (!ParkJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tens ligação á rede", Toast.LENGTH_SHORT).show();

            //Listener BD Local
            if (activitiesListener != null) {
                activitiesListener.onRefreshListaActivities(parkBDHelper.getAllAtividadesBD());
            }

        } else {
            StringRequest request = new StringRequest(Request.Method.GET, urlAPIAtividades + "/getall", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    System.out.println("---->"+IP);
                    activities = ParkJsonParser.parserJsonAtividades(response);
                    adicionarAtividadesBD(activities);

                    if (activitiesListener != null) {
                        activitiesListener.onRefreshListaActivities(activities);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                    System.out.println("-->" + error.getMessage());
                }
            });
            volleyQueue.add(request);
        }
    }
}