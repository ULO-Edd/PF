package com.example.parkjoy.Models;

import android.content.Context;

import org.eclipse.paho.client.mqttv3.IMqttDeliveryToken;
import org.eclipse.paho.client.mqttv3.MqttCallback;
import org.eclipse.paho.client.mqttv3.MqttClient;
import org.eclipse.paho.client.mqttv3.MqttMessage;
import org.json.JSONObject;

public class MosquittoCallBack implements MqttCallback {

    private Context context;

    public MosquittoCallBack(Context context) {
        this.context = context;
    }

    @Override
    public void connectionLost(Throwable cause) {
        System.out.println("Perda de ligação ao mosquitto");
    }

    @Override
    public void messageArrived(String topic, MqttMessage message) throws Exception {
        JSONObject jsonObject = new JSONObject(message.toString());

        News news = new News(
                jsonObject.getInt("id"),
                jsonObject.getString("titulo"),
                jsonObject.getString("descricao"),
                jsonObject.getString("date_expire"),
                jsonObject.getString("image")
        );

        SingletonParque.getInstance(context).parkBDHelper.adicionarNoticiasBD(news);

        SingletonParque.getInstance(context).novidadesListener.onRefreshNovidade();
    }

    @Override
    public void deliveryComplete(IMqttDeliveryToken token) {

    }
}

