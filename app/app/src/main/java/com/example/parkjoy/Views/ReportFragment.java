package com.example.parkjoy.Views;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

import com.example.parkjoy.Adaptador.TopicoSugestoesAdaptador;
import com.example.parkjoy.Listeners.TopicosListener;
import com.example.parkjoy.MainActivity;
import com.example.parkjoy.Models.ParkBDHelper;
import com.example.parkjoy.Models.SingletonParque;
import com.example.parkjoy.Models.Sugestao;
import com.example.parkjoy.Models.Topicos_Sugestoes;
import com.example.parkjoy.Models.User;
import com.example.parkjoy.Models.ParkBDHelper;
import com.example.parkjoy.R;

import java.lang.reflect.Array;
import java.util.ArrayList;


public class ReportFragment extends Fragment implements TopicosListener {

    private EditText etConteudo;
    private Button btnSend;
    private Spinner sTopicos;
    private ArrayList<Topicos_Sugestoes> arrayTopicos;
    private Array DropDownElements;
    private ArrayAdapter<CharSequence> adapter;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_report, container, false);

        etConteudo = view.findViewById(R.id.emt_content);
        sTopicos = view.findViewById(R.id.spinner_topic_report);
        btnSend = view.findViewById(R.id.btn_send);

        btnSend.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (!VerifyContentLength(etConteudo)){
                    etConteudo.setError("Preencha o conteudo");
                    return;
                }

                long PositionTopico = sTopicos.getSelectedItemId();

                Sugestao sugestao = new Sugestao(SingletonParque.getInstance(getContext()).getUserId() + "", Long.toString(PositionTopico), etConteudo.getText().toString());

                SingletonParque.getInstance(getContext()).sendReportAPI(sugestao, getContext());

                Intent intent = new Intent(getActivity(), MainActivity.class);
                startActivity(intent);
            }
        });

        SingletonParque.getInstance(getContext()).setTopicosListener(this);
        SingletonParque.getInstance(getContext()).getAllTopicosAPI(getContext());


        return view;
    }


    private boolean VerifyContentLength(EditText conteudo){

        if (conteudo.length() < 10){
            return false;
        }
        else
        {
            return true;
        }
    }

    @Override
    public void onRefreshTopicos(ArrayList<Topicos_Sugestoes> topicos) {
        if (topicos != null){
            sTopicos.setAdapter(new TopicoSugestoesAdaptador(getContext(), topicos));
        }
    }
}