package com.example.parkjoy.Views;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.app.ActionBar;
import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.example.parkjoy.Listeners.ActivitiesListener;
import com.example.parkjoy.Listeners.EventoListener;
import com.example.parkjoy.Listeners.NovidadeListener;
import com.example.parkjoy.MainActivity;
import com.example.parkjoy.Models.Pessoa;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.User;
import com.example.parkjoy.R;
import com.example.parkjoy.Utils.ParkJsonParser;

import org.json.JSONObject;

import java.util.Timer;
import java.util.TimerTask;

public class LoginActivity extends AppCompatActivity implements NovidadeListener, EventoListener {

    public static final String intentUsername = "username";
    private EditText etEmailUsername, etPassword;
    private Button btnChangeIP;
    private String username;
    private User user;
    private Pessoa pessoa;
    private Intent pendingIntent = null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        etEmailUsername = findViewById(R.id.et_emailUsername);
        etPassword = findViewById(R.id.et_password);
        btnChangeIP = findViewById(R.id.btn_ip);

        Intent intent = getIntent();

        SingletonParque.getInstance(getApplicationContext()).setEventoListener(this);
        SingletonParque.getInstance(getApplicationContext()).setNovidadeListener(this);

        username = intent.getStringExtra(intentUsername);
        etEmailUsername.setText(username);
        }

    private boolean VerifyEmailUsername(EditText EmailUsername){



        if (EmailUsername.length() != 0){
            return true;
        }
        else
        {
            return false;
        }
    }

    private boolean VerifyPassword(EditText Password){

        if (Password.length() != 0){
            return true;
        }
        else
        {
            return false;
        }
    }

    public void OnClickLogin(View view){

        if (!VerifyEmailUsername(etEmailUsername)){
            etEmailUsername.setError("Email ou Username Inválido");
            return;
        }
        else if (!VerifyPassword(etPassword)){
            etPassword.setError("Password Inválida");
            return;
        }

        SharedPreferences sharedPref = getSharedPreferences("mySharedPrefs", Context.MODE_PRIVATE);
        String ip = sharedPref.getString("IP", "");
        SingletonParque.setIP(ip);
        SingletonParque.getInstance(getApplicationContext()).loginUserAPI(getApplicationContext(), etEmailUsername.getText().toString(), etPassword.getText().toString(), new Response.Listener<JSONObject>() {
            @Override
            public void onResponse(JSONObject response) {
                SingletonParque.getInstance(getApplicationContext()).parkBDHelper.removerUserBD();
                SingletonParque.getInstance(getApplicationContext()).parkBDHelper.removerPessoaBD();

                user = ParkJsonParser.parserJsonUser(response);
                pessoa = ParkJsonParser.parserJsonPessoa(response);

                SingletonParque.getInstance(getApplicationContext()).parkBDHelper.adicionarUserBD(user);
                SingletonParque.getInstance(getApplicationContext()).parkBDHelper.adicionarPessoaBD(pessoa);

                Toast.makeText(getApplicationContext(), "Login realizado com sucesso", Toast.LENGTH_SHORT).show();
                String userName = etEmailUsername.getText().toString();

                Intent intent = new Intent(getApplicationContext(), MainActivity.class);
                intent.putExtra("userDenomination", userName);
                pendingIntent = intent;
                SingletonParque.getInstance(getApplicationContext()).getEvent(getApplicationContext());
                SingletonParque.getInstance(getApplicationContext()).getNovidade(getApplicationContext());
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getApplicationContext(), "Username ou Password incorreto", Toast.LENGTH_LONG).show();

            }
        });
    }

    public void OnClickRegister(View view){
        Intent intent = new Intent(getApplicationContext(), RegisterActivity.class);
        startActivity(intent);
    }

    private void dialogMudarIP() {
    AlertDialog.Builder builder = new AlertDialog.Builder(this);
        final EditText newIP = new EditText(getApplicationContext());
        builder.setMessage("Mudar o IP Address");
        builder.setTitle("Alterar o IP");

        SharedPreferences sharedPref = getSharedPreferences("mySharedPrefs", Context.MODE_PRIVATE);
        String ip = sharedPref.getString("IP", "");
        if(ip != null){
            newIP.setText(ip);
        }

        builder.setView(newIP);

        builder.setPositiveButton("Yes", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int whichButton) {
                //SingletonParque.setIP(""+newIP.getText().toString());
                SharedPreferences sharedPref = getSharedPreferences("mySharedPrefs", Context.MODE_PRIVATE);
                SharedPreferences.Editor editor = sharedPref.edit();
                editor.putString("IP", ""+newIP.getText().toString());
                editor.apply();
            }
        });

        builder.setNegativeButton("No", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int whichButton) {
                // what ever you want to do with No option.
            }
        });

        builder.show();
    }

    public void OnClickChangeIP(View view) {
        dialogMudarIP();
    }

    @Override
    public void onRefreshEvento(int op) {
        //MANTER VAZIO
    }

    @Override
    public void onRefreshNovidade(int op) {
        if(pendingIntent != null) {
            startActivity(pendingIntent);
            finish();
        }
        pendingIntent = null;
    }


}