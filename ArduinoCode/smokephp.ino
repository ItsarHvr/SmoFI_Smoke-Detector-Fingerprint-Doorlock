#include <WiFi.h>
#include <HTTPClient.h>

#define AO_PIN 36
const char *ssid = "ASARM Family";
const char *password = "17121997";
const char *serverAddress = "http://192.168.100.87/github/PBL_K3/vel/app/Http/Controllers/GasReadingController.php";

void setup() {
  Serial.begin(9600);
  Serial.println("Warming up the MQ2 sensor");
  delay(2000);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
}

void loop() {
  int gasValue = analogRead(AO_PIN);
  Serial.print("MQ2 value: ");
  Serial.println(gasValue);

  if (gasValue >= 1000) {
    Serial.println("Gas detected!");
    sendDataToServer(gasValue);
    delay(2000);
  } else {
    Serial.println("No Gas detected!");
    sendDataToServer(gasValue);
    delay(2000);
  }

  delay(2000);
}

void sendDataToServer(int gasValue) {
  HTTPClient http;
  String url = String(serverAddress) + "?gas_value=" + String(gasValue);

  http.begin(url);
  int httpResponseCode = http.GET();  // Mengubah POST menjadi GET

  if (httpResponseCode > 0) {
    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);
  } else {
    Serial.println("Failed to connect to server");
  }

  http.end();
}


