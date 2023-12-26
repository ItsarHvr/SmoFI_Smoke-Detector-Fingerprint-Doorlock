#include <ArduinoJson.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

const char *ssid = "Rumah ceria";
const char *password = "Kikiisan21";

// Ganti dengan URL endpoint yang ingin Anda akses di Laravel
const char *url = "http://192.168.100.4:8000/status-relay-json";

#define pin_relay D0

void setup() {
  Serial.begin(115200);

  // Connect to WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  delay(1000);

  Serial.println("Connected to WiFi");

  pinMode(pin_relay, OUTPUT);
  digitalWrite(pin_relay, LOW);
}

void loop() {
  WiFiClient wifiClient;
  HTTPClient http;

  http.begin(wifiClient, url);
  int httpCode = http.GET();

  String payload;

  if (httpCode > 0) {
    payload = http.getString();
    Serial.println(payload);

    // Parse JSON using ArduinoJson library
    DynamicJsonDocument doc(100);

    DeserializationError error = deserializeJson(doc, payload);
    if (error) {
      Serial.print(F("JSON parsing failed! Error: "));
      Serial.println(error.c_str());
      return;
    }

    int statusRelay = doc["statusRelay"].as<int>();

    digitalWrite(pin_relay, (statusRelay == 1) ? HIGH : LOW);
  } else {
    Serial.println("HTTP request failed");
    Serial.println(http.errorToString(httpCode).c_str());
  }

  http.end();
  delay(1000);
}
