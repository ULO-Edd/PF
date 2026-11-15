package com.example.parkjoy.Models;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import java.net.IDN;
import java.util.ArrayList;

public class ParkBDHelper extends SQLiteOpenHelper {

    private static final String DB_NAME = "dbParque";
    private static final int DB_VERSION = 1;

    private static final String TABLE_NAME_LOJA = "Lojas";
    private static final String DESIGNACAO_LOJA = "titulo";
    private static final String ID_LOJA = "id";

    private static final String TABLE_NAME_PRODUTO = "Produtos";
    private static final String ID_LOJA_PRODUTO = "id_loja";
    private static final String DESCRICAO_PRODUTO = "descricao";
    private static final String QUANTIDADE_PRODUTO = "quantidade";
    private static final String PONTOS_PRODUTO = "points";
    private static final String IMG_PRODUTO = "img";
    private static final String ID_PRODUTO = "id";

    private static final String TABLE_NAME_EVENTO = "Eventos";
    private static final String DESIGNACAO_EVENTO = "designacao";
    private static final String DESCRICAO_EVENTO = "descricao";
    private static final String DATA_INICIO_EVENTO = "data_inicio";
    private static final String DATA_CONCLUSAO_EVENTO = "data_conclusao";
    private static final String PONTOS_PARTICIPACAO_EVENTO = "pontos_participacao";
    private static final String ATIVO_EVENTO = "ativo";
    private static final String IMG_EVENTO = "img";
    private static final String ID_EVENTO = "id";

    private static final String TABLE_NAME_NEWS = "Noticias";
    private static final String TITULO_NEWS = "titulo";
    private static final String DESCRICAO_NEWS = "descricao";
    private static final String DATE_EXPIRE_NEWS = "date_expire";
    private static final String IMG_NEWS = "img";
    private static final String ID_NEWS = "id";

    private static final String TABLE_NAME_TOPICO = "Topicos";
    private static final String TOPICO_SUGESTAO = "topico";
    private static final String ID_TOPICO_SUGESTAO = "id";

    private static final String TABLE_NAME_ACTIVITY = "Atividades";
    private static final String DESIGNACAO_ACTIVITY = "designacao";
    private static final String DESCRICAO_ACTIVITY = "descricao";
    private static final String TIPO_ACTIVITY = "tipo_atividade";
    private static final String LOTACAO_ACTIVITY = "lotacao";
    private static final String IMG_ACTIVITY = "image";
    private static final String ID_ACTIVITY = "id";

    private static final String TABLE_NAME_TICKET = "Tickets";
    private static final String ID_PESSOA_TICKET = "id_pessoa";
    private static final String DATA_DE_USO_TICKET = "data_de_uso";
    private static final String DATA_DE_COMPRA_TICKET = "date_de_compra";
    private static final String ANULADO_TICKET = "anulado";
    private static final String EXPIRADO_TICKET = "expirado";
    private static final String PRE_COMPRA_TICKET = "pre_compra";
    private static final String PRECO_TICKET = "preco";
    private static final String NUMERO_ATIVIDADES_TICKET = "numero_atividades";
    private static final String ID_TICKET = "id";

    private static final String TABLE_NAME_USER = "User";
    private static final String USERNAME_USER = "username";
    private static final String EMAIL_USER = "email";
    private static final String ID_USER = "id";

    private static final String TABLE_NAME_PESSOA = "Pessoa";
    private static final String NOME_PESSOA = "name";
    private static final String LASTNOME_PESSOA = "lastname";
    private static final String TELEFONE_PESSOA = "telephone";
    private static final String DATA_DE_NASCIMENTO_PESSOA = "birthday_date";
    private static final String PONTOS_PESSOA = "points";
    private static final String ID_PESSOA = "id";

    private static final String TABLE_NAME_FAVORITO = "Favoritos";
    private static final String ID_USER_FAVORITO = "id_user";
    private static final String ID_ATIVIDADE_FAVORITO = "id_favorito";

    private static final String TABLE_NAME_PARTICIPAR = "Participar";
    private static final String ID_USER_PARTICIPAR = "id_user";
    private static final String ID_ATIVIDADE_PARTICIPAR = "id_atividade";

    private final SQLiteDatabase db;

    public ParkBDHelper(Context context) {
        super(context, DB_NAME, null, DB_VERSION);
        this.db = this.getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        String createLojaTable = "CREATE TABLE " + TABLE_NAME_LOJA + "(" +
                ID_LOJA + " INTEGER PRIMARY KEY NOT NULL, " +
                DESIGNACAO_LOJA + " TEXT NOT NULL " + ");" ;

        sqLiteDatabase.execSQL (createLojaTable);

        String createProdutoTable = "CREATE TABLE " + TABLE_NAME_PRODUTO + "(" +
                ID_PRODUTO + " INTEGER PRIMARY KEY NOT NULL, " +
                ID_LOJA_PRODUTO + " INTEGER NOT NULL, " +
                DESCRICAO_PRODUTO + " TEXT NOT NULL, " +
                QUANTIDADE_PRODUTO + " INTEGER NOT NULL, " +
                PONTOS_PRODUTO + " INTEGER NOT NULL, " +
                IMG_PRODUTO + " TEXT NOT NULL " + ");" ;

        sqLiteDatabase.execSQL (createProdutoTable);

        String createEventoTable = "CREATE TABLE " + TABLE_NAME_EVENTO + "(" +
                ID_EVENTO + " INTEGER PRIMARY KEY NOT NULL, " +
                DESIGNACAO_EVENTO + " TEXT NOT NULL, " +
                DESCRICAO_EVENTO + " TEXT NOT NULL, " +
                DATA_INICIO_EVENTO + " TEXT NOT NULL, " +
                DATA_CONCLUSAO_EVENTO + " TEXT NOT NULL, " +
                PONTOS_PARTICIPACAO_EVENTO + " INTEGER NOT NULL, " +
                ATIVO_EVENTO + " BOOLEAN NOT NULL, " +
                IMG_EVENTO + " TEXT NOT NULL " + ");" ;

        sqLiteDatabase.execSQL (createEventoTable);

        String createNoticiasTable = "CREATE TABLE " + TABLE_NAME_NEWS + "(" +
                ID_NEWS + " INTEGER PRIMARY KEY NOT NULL, " +
                TITULO_NEWS + " TEXT NOT NULL, " +
                DESCRICAO_NEWS + " TEXT NOT NULL, " +
                DATE_EXPIRE_NEWS + " TEXT NOT NULL, " +
                IMG_NEWS + " TEXT NOT NULL " + ");" ;

        sqLiteDatabase.execSQL (createNoticiasTable);

        String createTopicoSugestoesTable = "CREATE TABLE " + TABLE_NAME_TOPICO+ "(" +
                ID_TOPICO_SUGESTAO + " INTEGER PRIMARY KEY NOT NULL, " +
                TOPICO_SUGESTAO + " TEXT NOT NULL " + ");" ;

        sqLiteDatabase.execSQL (createTopicoSugestoesTable);

        String createAtividadesTable = "CREATE TABLE " + TABLE_NAME_ACTIVITY+ "(" +
                ID_ACTIVITY + " INTEGER PRIMARY KEY NOT NULL, " +
                TIPO_ACTIVITY + " TEXT NOT NULL, " +
                DESIGNACAO_ACTIVITY + " TEXT NOT NULL, " +
                DESCRICAO_ACTIVITY + " TEXT NOT NULL, " +
                LOTACAO_ACTIVITY + " INTEGER NOT NULL, " +
                IMG_ACTIVITY + " TEXT NOT NULL " + ");" ;

        sqLiteDatabase.execSQL (createAtividadesTable);

        String createTicketsTable = "CREATE TABLE " + TABLE_NAME_TICKET+ "(" +
                ID_TICKET + " INTEGER PRIMARY KEY NOT NULL, " +
                ID_PESSOA_TICKET + " INTEGER NOT NULL, " +
                DATA_DE_COMPRA_TICKET + " TEXT NOT NULL, " +
                DATA_DE_USO_TICKET + " TEXT NOT NULL, " +
                ANULADO_TICKET + " BOOLEAN NOT NULL, " +
                EXPIRADO_TICKET + " BOOLEAN NOT NULL, " +
                PRE_COMPRA_TICKET + " BOOLEAN NOT NULL, " +
                PRECO_TICKET + " INTEGER NOT NULL, " +
                NUMERO_ATIVIDADES_TICKET + " INTEGER NOT NULL " + ");" ;

        sqLiteDatabase.execSQL (createTicketsTable);

        String createUserTable = "CREATE TABLE " + TABLE_NAME_USER+ "(" +
                ID_USER + " INTEGER PRIMARY KEY NOT NULL, " +
                USERNAME_USER + " TEXT NOT NULL, " +
                EMAIL_USER + " TEXT NOT NULL " + ");" ;

        sqLiteDatabase.execSQL (createUserTable);

        String createPessoaTable = "CREATE TABLE " + TABLE_NAME_PESSOA+ "(" +
                ID_PESSOA + " INTEGER PRIMARY KEY NOT NULL, " +
                NOME_PESSOA + " INTEGER NOT NULL, " +
                LASTNOME_PESSOA + " TEXT NOT NULL, " +
                DATA_DE_NASCIMENTO_PESSOA + " TEXT NOT NULL, " +
                TELEFONE_PESSOA + " INTEGER NOT NULL, " +
                PONTOS_PESSOA + " INTEGER NOT NULL " +");" ;

        sqLiteDatabase.execSQL (createPessoaTable);

        String createFavoritoTable = "CREATE TABLE " + TABLE_NAME_FAVORITO+ "(" +
                ID_USER_FAVORITO + " INTEGER NOT NULL, " +
                ID_ATIVIDADE_FAVORITO + " INTEGER NOT NULL);" ;

        sqLiteDatabase.execSQL (createFavoritoTable);

        String createParticiparTable = "CREATE TABLE " + TABLE_NAME_PARTICIPAR+ "(" +
                ID_USER_PARTICIPAR + " INTEGER NOT NULL, " +
                ID_ATIVIDADE_PARTICIPAR + " INTEGER NOT NULL );" ;

        sqLiteDatabase.execSQL (createParticiparTable);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        db.execSQL(" DROP TABLE IF EXISTS " + TABLE_NAME_LOJA);
        this.onCreate(db);
        db.execSQL(" DROP TABLE IF EXISTS " + TABLE_NAME_PRODUTO);
        this.onCreate(db);
        db.execSQL(" DROP TABLE IF EXISTS " + TABLE_NAME_EVENTO);
        this.onCreate(db);
        db.execSQL(" DROP TABLE IF EXISTS " + TABLE_NAME_NEWS);
        this.onCreate(db);
        db.execSQL(" DROP TABLE IF EXISTS " + TABLE_NAME_TOPICO);
        this.onCreate(db);
        db.execSQL(" DROP TABLE IF EXISTS " + TABLE_NAME_ACTIVITY);
        this.onCreate(db);
        db.execSQL(" DROP TABLE IF EXISTS " + TABLE_NAME_TICKET);
        this.onCreate(db);
        db.execSQL(" DROP TABLE IF EXISTS " + TABLE_NAME_USER);
        this.onCreate(db);
        db.execSQL(" DROP TABLE IF EXISTS " + TABLE_NAME_PESSOA);
        this.onCreate(db);
        db.execSQL(" DROP TABLE IF EXISTS " + TABLE_NAME_FAVORITO);
        this.onCreate(db);
        db.execSQL(" DROP TABLE IF EXISTS " + TABLE_NAME_PARTICIPAR);
        this.onCreate(db);
    }

    public Loja adicionarLojaBD(Loja loja){

        ContentValues values = new ContentValues();
        values.put(ID_LOJA, loja.getId());
        values.put(DESIGNACAO_LOJA, loja.getDesignacao());

        long id = this.db.insert(TABLE_NAME_LOJA, null, values);

        return null;
    }

    public Loja getLojaBD(){

        Loja lojaAux = null;

        Cursor cursor = this.db.query(TABLE_NAME_PRODUTO, new String[]{ID_LOJA, DESIGNACAO_LOJA},
                null, null, null, null, null);

        if(cursor.moveToFirst()){
                lojaAux = new Loja(cursor.getInt(0), cursor.getString(1));
        }

        return lojaAux;
    }

    public void removerLojaBD() {
        db.delete(TABLE_NAME_LOJA, null, null);
    }

    //----------------------------

    public Produto adicionarProdutosBD(Produto produto){

        ContentValues values = new ContentValues();
        values.put(ID_PRODUTO, produto.getId());
        values.put(ID_LOJA_PRODUTO, produto.getIdLoja());
        values.put(DESCRICAO_PRODUTO, produto.getDescricao());
        values.put(QUANTIDADE_PRODUTO, produto.getQuantidade());
        values.put(PONTOS_PRODUTO, produto.getPontos());
        values.put(IMG_PRODUTO, produto.getImg());

        long id = this.db.insert(TABLE_NAME_PRODUTO, null, values);

        return null;
    }

    public ArrayList<Produto> getAllLojaProdutosBD(){

        ArrayList<Produto> produtos = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_NAME_PRODUTO, new String[]{ID_PRODUTO, ID_LOJA_PRODUTO, DESCRICAO_PRODUTO, QUANTIDADE_PRODUTO, PONTOS_PRODUTO, IMG_PRODUTO},
                null, null, null, null, null);

        if(cursor.moveToFirst()){
            do {
                Produto produtoAux = new Produto(cursor.getInt(0), cursor.getInt(1), cursor.getString(2), cursor.getInt(3), cursor.getInt(4), cursor.getString(5));
                produtos.add(produtoAux);
            }while (cursor.moveToNext());
        }
        return produtos;
    }

    public void removerAllProdutosBD() {
        db.delete(TABLE_NAME_PRODUTO, null, null);
    }

    //----------------------------

    public Evento adicionarEventosBD(Evento evento){


        ContentValues values = new ContentValues();
        values.put(ID_EVENTO, evento.getId());
        values.put(DESIGNACAO_EVENTO, evento.getDesignacao());
        values.put(DESCRICAO_EVENTO, evento.getDescricao());
        values.put(DATA_INICIO_EVENTO, evento.getDataInicio());
        values.put(DATA_CONCLUSAO_EVENTO, evento.getDataConclusao());
        values.put(PONTOS_PARTICIPACAO_EVENTO, evento.getPontosParticipacao());
        values.put(ATIVO_EVENTO, evento.isAtivo());
        values.put(IMG_EVENTO, evento.getImg());

        long id = this.db.insert(TABLE_NAME_EVENTO, null, values);

        return null;
    }

    public ArrayList<Evento> getAllEventosBD(){

        ArrayList<Evento> events = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_NAME_EVENTO, new String[]{ID_EVENTO, DESIGNACAO_EVENTO, DESCRICAO_EVENTO, DATA_INICIO_EVENTO, DATA_CONCLUSAO_EVENTO, PONTOS_PARTICIPACAO_EVENTO, ATIVO_EVENTO, IMG_EVENTO},
                null, null, null, null, null);

        if(cursor.moveToFirst()){
            do {
                Evento eventAux = new Evento(cursor.getInt(0), cursor.getString(1), cursor.getString(2), cursor.getString(3), cursor.getString(4), cursor.getInt(5), cursor.getInt(6), cursor.getString(7));
                events.add(eventAux);
            }while (cursor.moveToNext());
        }
        return events;
    }

    public Evento getLatestEventBD() {
        Evento evento = null;

        Cursor cursor = this.db.query(TABLE_NAME_EVENTO, new String[]{ID_EVENTO, DESIGNACAO_EVENTO, DESCRICAO_EVENTO, DATA_INICIO_EVENTO, DATA_CONCLUSAO_EVENTO, PONTOS_PARTICIPACAO_EVENTO, ATIVO_EVENTO, IMG_EVENTO},
                null, null, null, null, null);

        if(cursor.moveToFirst()) {
            evento = new Evento(cursor.getInt(0), cursor.getString(1), cursor.getString(2), cursor.getString(3), cursor.getString(4), cursor.getInt(5), cursor.getInt(6), cursor.getString(7));
        }

        return evento;
    }

    public void removerAllEventosBD() {
        db.delete(TABLE_NAME_EVENTO, null, null);
    }

    //----------------------------

    public News adicionarNoticiasBD(News news){


        ContentValues values = new ContentValues();
        values.put(ID_NEWS, news.getId());
        values.put(TITULO_NEWS, news.getTitulo());
        values.put(DESCRICAO_NEWS, news.getDescricao());
        values.put(DATE_EXPIRE_NEWS, news.getDateExpire());
        values.put(IMG_NEWS, news.getImg());

        long id = this.db.insert(TABLE_NAME_NEWS, null, values);

        return null;
    }

    public ArrayList<News> getAllNoticiasBD(){

        ArrayList<News> news = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_NAME_NEWS, new String[]{ID_NEWS, TITULO_NEWS, DESCRICAO_NEWS, DATE_EXPIRE_NEWS, IMG_NEWS},
                null, null, null, null, null);

        if(cursor.moveToFirst()){
            do {
                News newsAux = new News(cursor.getInt(0), cursor.getString(1), cursor.getString(2), cursor.getString(3), cursor.getString(4));
                news.add(newsAux);
            }while (cursor.moveToNext());
        }
        return news;
    }

    public News getLatestNewsBD() {
        News news = null;

        Cursor cursor = this.db.query(TABLE_NAME_NEWS, new String[]{ID_NEWS, TITULO_NEWS, DESCRICAO_NEWS, DATE_EXPIRE_NEWS, IMG_NEWS},
                null, null, null, null, null);

        if(cursor.moveToFirst()) {
            news = new News(cursor.getInt(0), cursor.getString(1), cursor.getString(2), cursor.getString(3), cursor.getString(4));
        }

        return news;
    }

    public void removerAllNoticiasBD() {
        db.delete(TABLE_NAME_NEWS, null, null);
    }

    //----------------------------


    public Topicos_Sugestoes adicionarTopicosBD(Topicos_Sugestoes topicos){


        ContentValues values = new ContentValues();
        values.put(TOPICO_SUGESTAO, topicos.getTopico());

        long id = this.db.insert(TABLE_NAME_TOPICO, null, values);

        return null;
    }

    public ArrayList<Topicos_Sugestoes> getAllTopicosBD(){

        ArrayList<Topicos_Sugestoes> topicos = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_NAME_TOPICO, new String[]{ID_TOPICO_SUGESTAO, TOPICO_SUGESTAO},
                null, null, null, null, null);

        if(cursor.moveToFirst()){
            do {
                Topicos_Sugestoes TopSugAux = new Topicos_Sugestoes(cursor.getInt(0), cursor.getString(1));
                topicos.add(TopSugAux);
            }while (cursor.moveToNext());
        }
        return topicos;
    }

    public void removerAllTopicosBD() {
        db.delete(TABLE_NAME_TOPICO, null, null);
    }

    //----------------------------

    public Activities adicionarAtividadesBD(Activities act){


        ContentValues values = new ContentValues();
        values.put(ID_ACTIVITY, act.getId());
        values.put(TIPO_ACTIVITY, act.getTipoAtividade());
        values.put(DESIGNACAO_ACTIVITY, act.getDesignacao());
        values.put(DESCRICAO_ACTIVITY, act.getDescricao());
        values.put(LOTACAO_ACTIVITY, act.getLotacao());
        values.put(IMG_ACTIVITY, act.getImg());

        long id = this.db.insert(TABLE_NAME_ACTIVITY, null, values);

        return null;
    }

    public ArrayList<Activities> getAllAtividadesBD(){

        ArrayList<Activities> activities = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_NAME_ACTIVITY, new String[]{ID_ACTIVITY, TIPO_ACTIVITY, DESIGNACAO_ACTIVITY, DESCRICAO_ACTIVITY, LOTACAO_ACTIVITY, IMG_ACTIVITY},
                null, null, null, null, null);

        if(cursor.moveToFirst()){
            do {
                Activities actAux = new Activities(cursor.getInt(0), cursor.getString(1), cursor.getString(2), cursor.getString(3), cursor.getInt(4),cursor.getString(5));
                activities.add(actAux);
            }while (cursor.moveToNext());
        }
        return activities;
    }

    public Activities getAtividadeBD(int id){
        ArrayList<Activities> allActivities = getAllAtividadesBD();

        for (Activities activities: allActivities) {
            if(activities.getId() == id)
                return activities;
        }
        return null;
    }


    public void removerAllAtividadesBD() {
        db.delete(TABLE_NAME_ACTIVITY, null, null);
    }

    //----------------------------

    public Activities adicionarTicketsBD(Ticket ticket){


        ContentValues values = new ContentValues();
        values.put(ID_TICKET, ticket.getId());
        values.put(ID_PESSOA_TICKET, ticket.getIdPessoa());
        values.put(DATA_DE_COMPRA_TICKET, ticket.getDataDeCompra());
        values.put(DATA_DE_USO_TICKET, ticket.getDataDeUso());
        values.put(ANULADO_TICKET, ticket.getAnulado());
        values.put(EXPIRADO_TICKET, ticket.getExpirado());
        values.put(PRE_COMPRA_TICKET, ticket.getPre_compra());
        values.put(PRECO_TICKET, ticket.getPreco());
        values.put(NUMERO_ATIVIDADES_TICKET, ticket.getNumero_atividades());
        long id = this.db.insert(TABLE_NAME_TICKET, null, values);

        return null;
    }

    public ArrayList<Ticket> getAllTicketsBD(){

        ArrayList<Ticket> tickets = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_NAME_TICKET, new String[]{ID_TICKET, ID_PESSOA_TICKET, DATA_DE_COMPRA_TICKET, DATA_DE_USO_TICKET, EXPIRADO_TICKET, ANULADO_TICKET, PRE_COMPRA_TICKET, PRECO_TICKET, NUMERO_ATIVIDADES_TICKET},
                null, null, null, null, null);

        if(cursor.moveToFirst()){
            do {
                Ticket tickAux = new Ticket(cursor.getInt(0), cursor.getInt(1), cursor.getString(2), cursor.getString(3), cursor.getInt(4), cursor.getInt(5), cursor.getInt(6), cursor.getInt(7), cursor.getInt(8));
                tickets.add(tickAux);
            }while (cursor.moveToNext());
        }
        return tickets;
    }

    public ArrayList<Ticket> getAllTicketsUserBD(int id){

        ArrayList<Ticket> tickets = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_NAME_TICKET, new String[]{ID_TICKET, ID_PESSOA_TICKET, DATA_DE_COMPRA_TICKET, DATA_DE_USO_TICKET, EXPIRADO_TICKET, ANULADO_TICKET, PRE_COMPRA_TICKET, PRECO_TICKET, NUMERO_ATIVIDADES_TICKET},
                null, null, null, null, null);

        if(cursor.moveToFirst()){
            do {
                Ticket tickAux = new Ticket(cursor.getInt(0), cursor.getInt(1), cursor.getString(2), cursor.getString(3), cursor.getInt(4), cursor.getInt(5), cursor.getInt(6), cursor.getInt(7), cursor.getInt(8));
                if (tickAux.getIdPessoa() == id && tickAux.getAnulado() == 0 && tickAux.getExpirado() == 0 && tickAux.getPre_compra() == 0)
                {
                    tickets.add(tickAux);
                }
            }while (cursor.moveToNext());
        }
        return tickets;
    }


    public void removerAllTicketsBD() {
        db.delete(TABLE_NAME_TICKET, null, null);
    }

    //----------------------------

    public User adicionarUserBD(User user){


        ContentValues values = new ContentValues();
        values.put(ID_USER, user.getId());
        values.put(USERNAME_USER, user.getUsername());
        values.put(EMAIL_USER, user.getEmail());


        long id = this.db.insert(TABLE_NAME_USER, null, values);

        return null;
    }

    public User getUserBD(){
        User user = null;

        Cursor cursor = this.db.query(TABLE_NAME_USER, new String[]{ID_USER, USERNAME_USER, EMAIL_USER},
                null, null, null, null, null);
        if(cursor.moveToFirst()) {
            do {

                user = new User(cursor.getInt(0), cursor.getString(1), cursor.getString(2));
            } while (cursor.moveToNext());
        }

        return user;
    }

    public void removerUserBD(){ db.delete(TABLE_NAME_USER, null, null);}

    //----------------------------

    public Pessoa adicionarPessoaBD(Pessoa pessoa){


        ContentValues values = new ContentValues();
        values.put(ID_PESSOA, pessoa.getId());
        values.put(NOME_PESSOA, pessoa.getNome());
        values.put(LASTNOME_PESSOA, pessoa.getLastnome());
        values.put(DATA_DE_NASCIMENTO_PESSOA, pessoa.getBirthday());
        values.put(TELEFONE_PESSOA, pessoa.getTelephone());
        values.put(PONTOS_PESSOA, pessoa.getPoints());




        long id = this.db.insert(TABLE_NAME_PESSOA, null, values);

        return null;
    }

    public Pessoa getPessoaBD(){
        Pessoa pessoa = null;

        Cursor cursor = this.db.query(TABLE_NAME_PESSOA, new String[]{ID_PESSOA, NOME_PESSOA, LASTNOME_PESSOA, DATA_DE_NASCIMENTO_PESSOA, TELEFONE_PESSOA, PONTOS_PESSOA},
                null, null, null, null, null);
        if(cursor.moveToFirst()) {
            do {
            pessoa = new Pessoa(cursor.getInt(0), cursor.getString(1), cursor.getString(2), cursor.getString(3), cursor.getString(4), cursor.getInt(5));
            } while (cursor.moveToNext());
        }

        return pessoa;
    }

    public void removerPessoaBD(){ db.delete(TABLE_NAME_PESSOA, null, null);}

    //----------------------------

    public Favorito adicionarFavoritoBD(int id_user, int id_atividade){


        ContentValues values = new ContentValues();
        values.put(ID_USER_FAVORITO, id_user);
        values.put(ID_ATIVIDADE_FAVORITO, id_atividade);



        long id = this.db.insert(TABLE_NAME_FAVORITO, null, values);

        return null;
    }

    public ArrayList<Favorito> getAllFavoritosBD(){

        ArrayList<Favorito> favoritos = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_NAME_FAVORITO, new String[]{ID_USER_FAVORITO, ID_ATIVIDADE_FAVORITO},
                null, null, null, null, null);
        if(cursor.moveToFirst()) {
            do {
                Favorito favoritoaux = new Favorito(cursor.getInt(0), cursor.getInt(1));
                favoritos.add(favoritoaux);
            }while (cursor.moveToNext());
        }
        return favoritos;
    }

    public Favorito getFavoritoBD(int id){
        Favorito favorito = null;

        Cursor cursor = this.db.query(TABLE_NAME_FAVORITO, new String[]{ID_USER_FAVORITO, ID_ATIVIDADE_FAVORITO},
                null, null, null, null, null);
        if(cursor.moveToFirst()) {
            do {
                Favorito favoritoaux = new Favorito(cursor.getInt(0), cursor.getInt(1));
                if (favoritoaux.getId_atividade() == id){
                    favorito = favoritoaux;
                }
            } while (cursor.moveToNext());
        }

        return favorito;
    }

    public void removerFavoritoBD(){ db.delete(TABLE_NAME_FAVORITO, null, null);}

    //----------------------------

    public Participar adicionarParticipacaoBD(int id_user, int id_atividade){


        ContentValues values = new ContentValues();
        values.put(ID_USER_PARTICIPAR, id_user);
        values.put(ID_ATIVIDADE_PARTICIPAR, id_atividade);



        long id = this.db.insert(TABLE_NAME_PARTICIPAR, null, values);

        return null;
    }

    public Participar getParticiparBD(){
        Participar participar = null;

        Cursor cursor = this.db.query(TABLE_NAME_FAVORITO, new String[]{ID_USER_FAVORITO, ID_ATIVIDADE_FAVORITO},
                null, null, null, null, null);
        if(cursor.moveToFirst()) {
            do {
                participar = new Participar(cursor.getInt(0), cursor.getInt(1));

            } while (cursor.moveToNext());
            return participar;
        }

        return null;
    }

    public void removerParticiparBD(){ db.delete(TABLE_NAME_PARTICIPAR, null, null);}

}








