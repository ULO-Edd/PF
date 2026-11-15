package com.example.parkjoy.Views;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.util.Patterns;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.example.parkjoy.Listeners.EventoListener;
import com.example.parkjoy.Listeners.NovidadeListener;
import com.example.parkjoy.MainActivity;
import com.example.parkjoy.Models.Pessoa;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.User;
import com.example.parkjoy.R;

import org.json.JSONObject;

public class MyInfoActivity extends AppCompatActivity implements EventoListener {

    private EditText etUsername, etEmail, etTelephone;
    private TextView tvNome, tvApelido, tvBday;
    private Intent pendingIntent = null;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_my_info);

        etUsername = findViewById(R.id.et_my_Username);
        etEmail = findViewById(R.id.et_my_Email);
        etTelephone = findViewById(R.id.et_my_Telephone);
        tvNome = findViewById(R.id.tv_my_Name);
        tvApelido = findViewById(R.id.tv_my_LastName);
        tvBday = findViewById(R.id.tv_my_Bday);

        User user = SingletonParque.getInstance(getApplicationContext()).parkBDHelper.getUserBD();
        Pessoa pessoa = SingletonParque.getInstance(getApplicationContext()).parkBDHelper.getPessoaBD();

        SingletonParque.getInstance(getApplicationContext()).setEventoListener(this);

        etUsername.setHint(user.getUsername());
        etEmail.setHint(user.getEmail());
        etTelephone.setHint(pessoa.getTelephone());
        tvNome.setText(pessoa.getNome());
        tvApelido.setText(pessoa.getLastnome());
        tvBday.setText(pessoa.getBirthday());

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

    public void OnClickChangeMyInfo(View view) {

        User user = SingletonParque.getInstance(getApplicationContext()).parkBDHelper.getUserBD();

        String newUsername = etUsername.getText().toString();
        if (newUsername.equals(""))
        {
            newUsername = etUsername.getHint().toString();
        }
        String newEmail = etEmail.getText().toString();
        if (newEmail.equals(""))
        {
            newEmail = etEmail.getHint().toString();
        }
        int newTelephone = 0;
        if (etTelephone.getText().toString().equals(""))
        {
            newTelephone = Integer.parseInt(etTelephone.getHint().toString());
        }
        else {
            newTelephone = Integer.parseInt(etTelephone.getText().toString());
        }

        if (!VerifyUsername(newUsername)){
            etUsername.setError("Username Inválida");
            return;
        }
        else if (!VerifyEmail(newEmail)){
            etEmail.setError("Email Inválido");
            return;
        }
        else if (!VerifyTelephone(newTelephone)){
            etTelephone.setError("Numero Telefone inválido");
            return;
        }

        String finalNewUsername = newUsername;
        SingletonParque.getInstance(getApplicationContext()).modifyUserAPI(getApplicationContext(),user.getId(), newUsername, newEmail, newTelephone, new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        Toast toast = Toast.makeText(getApplicationContext(), "Alterações realizadas com sucesso", Toast.LENGTH_LONG);
                        toast.show();

                        SingletonParque.getInstance(getApplicationContext()).getUserAPI(getApplicationContext(), user.getId());


                        Intent intent = new Intent(getApplicationContext(), MainActivity.class);
                        intent.putExtra("userDenomination", finalNewUsername);
                        pendingIntent = intent;
                        SingletonParque.getInstance(getApplicationContext()).getEvent(getApplicationContext());
                        SingletonParque.getInstance(getApplicationContext()).getNovidade(getApplicationContext());
                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(getApplicationContext(), "Erro ao modificar alterações", Toast.LENGTH_LONG).show();
                        System.out.println("--->" + error);

                    }
             }
        );
    }

    @Override
    public void onRefreshEvento(int op) {
        if(pendingIntent != null) {
            startActivity(pendingIntent);
            finish();
        }
        pendingIntent = null;
    }
}