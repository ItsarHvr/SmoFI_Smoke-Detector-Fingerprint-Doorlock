#include <ESP8266WiFi.h>

const char* ssid = "Redmi 9C";
const char* password = "3c74b723c4ae";

void setup() {
  Serial.begin(115200);

  // Menghubungkan ESP8266 ke jaringan Wi-Fi
  WiFi.begin(ssid, password);

  Serial.print("Connecting to WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  // Jika ESP8266 berhasil terhubung ke Wi-Fi
  Serial.println("\nConnected to WiFi");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  // Kode utama Anda dapat diletakkan di sini
}
