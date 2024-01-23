#include <WiFi.h>
#include <ArduinoJson.h>
#include <PubSubClient.h>

const char* ssid = "Rumah ceria";
const char* password = "Kikiisan21";
const char* mqtt_server = "192.168.100.68";
const int mqtt_port = 1883;
const char* mqtt_username = "";
const char* mqtt_password = "";
const char* topic1 = "pbl/smoke";
const char* topic2 = "pbl/relay";

const int mq2Pin = 36;
const int buzzerPin = 23;

WiFiClient espClient;
PubSubClient client(espClient);

void setup() {
  Serial.begin(115200);
  WiFi.begin(ssid, password);

  Serial.print("Connecting to WiFi...");
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }

  Serial.println("Connected to WiFi");
  Serial.print("Local IP Address: ");
  Serial.println(WiFi.localIP());

  client.setServer(mqtt_server, mqtt_port);
  client.setCallback(callback);
  connectToMQTT();

  pinMode(mq2Pin, INPUT);
  pinMode(buzzerPin, OUTPUT);
}

void loop() {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("Not connected to WiFi... Connecting now.");
    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED) {
      delay(1000);
      Serial.println("Connecting to WiFi...");
    }
  }

  if (!client.connected()) {
    connectToMQTT();
  }

  client.loop();

  int mq2Value = analogRead(mq2Pin);

  Serial.print("MQ2 Value: ");
  Serial.println(mq2Value);
  sendSmokeValue(mq2Value);
  if (mq2Value > 2000){
    Serial.println("Smoke Detected");
    sendRelayStatus();
    buzzer();   
  }

  delay(1000);
}

void connectToMQTT() {
  while (!client.connected()) {
    Serial.println("Connecting to MQTT...");
    if (client.connect("ESP8266Client", mqtt_username, mqtt_password)) {
      Serial.println("Connected to MQTT broker");
      client.subscribe(topic1);
      client.subscribe(topic2);
    } else {
      Serial.print("Failed, rc=");
      Serial.print(client.state());
      Serial.println(" Retrying in 5 seconds...");
      delay(5000);
    }
  }
}

void callback(char* topic, byte* payload, unsigned int length) {
  Serial.println("Message arrived in topic: " + String(topic));
}

void sendSmokeValue(int mq2Value) {
  connectToMQTT();
  String jsonPayload = "{\"smokeValue\":" + String(mq2Value) + "}";
  client.publish(topic1, jsonPayload.c_str());

  Serial.println("Smoke Value sent to EMQX");
}

void sendRelayStatus() {
  connectToMQTT();
  int mqttRelayState = 1;

  String jsonPayload = "{\"statusRelay\":" + String(mqttRelayState) + "}";
  client.publish(topic2, jsonPayload.c_str());

  Serial.println("Relay status sent to MQTT");
}

void buzzer(){
  digitalWrite(buzzerPin, HIGH);
  delay(3000);
  digitalWrite(buzzerPin, LOW);
}
