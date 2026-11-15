package com.example.parkjoy.Views;

import androidx.appcompat.app.AppCompatActivity;

import android.app.DatePickerDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.util.Patterns;
import android.view.View;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.example.parkjoy.MainActivity;
import com.example.parkjoy.Models.Pessoa;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.User;
import com.example.parkjoy.R;

import org.json.JSONObject;

import java.util.Calendar;
import java.util.Date;

public class RegisterActivity extends AppCompatActivity {

    private EditText etNome, etApelido, etUsername, etEmail, etPassword, etTelephone;
    private Button btnBday;
    private DatePickerDialog.OnDateSetListener dtBdayListener;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        SharedPreferences sharedPref = getSharedPreferences("mySharedPrefs", Context.MODE_PRIVATE);
        String ip = sharedPref.getString("IP", "");
        SingletonParque.setIP(ip);

        etNome = findViewById(R.id.et_registerName);
        etApelido = findViewById(R.id.et_registerLastName);
        btnBday = findViewById(R.id.btn_registerBirthDate);
        etUsername = findViewById(R.id.et_registerUsername);
        etEmail = findViewById(R.id.et_registerEmail);
        etTelephone = findViewById(R.id.et_registerTelephone);
        etPassword = findViewById(R.id.et_registerPassword);

        btnBday.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Calendar cal = Calendar.getInstance();
                int year = cal.get(Calendar.YEAR);
                int month = cal.get(Calendar.MONTH);
                int day = cal.get(Calendar.DAY_OF_MONTH);

                DatePickerDialog dialog = new DatePickerDialog(RegisterActivity.this, android.R.style.Theme_Holo_Light_Dialog_MinWidth, dtBdayListener, year,month,day);
                dialog.getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));
                dialog.show();
            }
        });

        dtBdayListener = new DatePickerDialog.OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                System.out.println("-->" + "date:" + year +"-"+ month +"-"+ dayOfMonth);
                month += 1;
                btnBday.setText(year +"-"+ month +"-"+ dayOfMonth);
            }
        };
    }

    private boolean VerifyName(String name){

        if (name.length() != 0){
            return true;
        }
        else
        {
            return false;
        }
    }

    private boolean VerifyLastName(String lastName){

        if (lastName.length() != 0){
            return true;
        }
        else
        {
            return false;
        }
    }

    private boolean VerifyUsername(String username){

        if (username.length() != 0){
            return true;
        }
        else
        {
            return false;
        }
    }

    private boolean VerifyEmail(String email){

        if (email.length() != 0){
            return true;
        }
        else if (Patterns.EMAIL_ADDRESS.matcher(email).matches())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private boolean VerifyDataNascimento(){
        if (btnBday.getText() != "Data de Nascimento"){
            return true;
        }
        return false;
    }

    private boolean VerifyTelephone(int telephone) {

        if (telephone >= 910000000 && telephone <= 969999999) {
            if ((telephone >= 920000000 && telephone <= 929999999) || (telephone >= 940000000 && telephone <= 949999999) || (telephone >= 950000000 && telephone <= 959999999)){
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    private boolean VerifyPassword(String password) {

        if (password.length() >= 8) {
            return true;
        } else {
            return false;
        }
    }

    public void OnClickNewRegist(View view){

        String email = etEmail.getText().toString();
        String password = etPassword.getText().toString();
        String dateNascimento = btnBday.getText().toString();
        String username = etUsername.getText().toString();
        String nome = etNome.getText().toString();
        String apelido = etApelido.getText().toString();
        int telephone = Integer.parseInt(etTelephone.getText().toString());

        if(!VerifyName(nome)) {
            etNome.setError("Nome Inválido");
            return;
        }
        else if(!VerifyLastName(apelido)) {
            etApelido.setError("Apelido Inválido");
            return;
        }
        else if (!VerifyDataNascimento()){
            btnBday.setError("Data não definida");
            return;
        }
        else if (!VerifyUsername(username)){
            etUsername.setError("Username Inválida");
            return;
        }
        else if (!VerifyEmail(email)){
            etEmail.setError("Email Inválido");
            return;
        }
        else if (!VerifyTelephone(telephone)){
            etTelephone.setError("Numero Telefone Superior ou Inferior a 9 digitos");
            return;
        }
        else if (!VerifyPassword(password)){
            etPassword.setError("Password Inferior a 8");
            return;
        }

        SingletonParque.getInstance(getApplicationContext()).registerUserAPI(getApplicationContext(), username, nome, apelido, dateNascimento, email, password, telephone, new Response.Listener<JSONObject>() {
            @Override
            public void onResponse(JSONObject response) {
                Toast toast = Toast.makeText(getApplicationContext(), "Registo Efetuado com sucesso", Toast.LENGTH_LONG);
                toast.show();

                Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
                intent.putExtra("username", username);
                startActivity(intent);
                finish();
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getApplicationContext(), "Erro ao registar: Campos inválidos", Toast.LENGTH_LONG).show();
                System.out.println("--->" + error);

            }
        }
        );
    }
}