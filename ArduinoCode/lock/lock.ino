#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

// Ganti dengan SSID dan password WiFi Anda
const char *ssid = "ASARM Family";
const char *password = "17121997";

// Ganti dengan URL endpoint yang ingin Anda akses
const char *url = "http://192.168.100.245/lockunlock/lock/baca_relay.php";

#define pin_relay 5 //pin GPIO5 = D1

void setup() {
  Serial.begin(115200);

  // Menghubungkan ke jaringan WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  delay(1000);  // Tambahkan delay setelah koneksi WiFi

  Serial.println("Connected to WiFi");

  pinMode(pin_relay, OUTPUT);
  // status awal mati/off
  digitalWrite(pin_relay, LOW);
}

void loop() {
  // Membuat objek WiFiClient
  WiFiClient wifiClient;

  // Mulai koneksi HTTP
  HTTPClient http;

  // Atur URL target
  http.begin(wifiClient, url);

  // Lakukan permintaan HTTP GET
  int httpCode = http.GET();

  // Deklarasikan payload di luar blok if
  String payload;

  // Periksa hasil permintaan
  if (httpCode > 0) {
    payload = http.getString();
    Serial.println(payload);
    
    //ubah status relay di nodemcu
    digitalWrite(pin_relay, (payload.toInt() == 1) ? LOW : HIGH);
  } else {
    Serial.println("HTTP request failed");
    Serial.println(http.errorToString(httpCode).c_str());
  }

  // Tutup koneksi HTTP
  http.end();

  // Tambahkan delay sesuai kebutuhan
  delay(1000); // Contoh delay 5 detik (5000 milidetik)
}
