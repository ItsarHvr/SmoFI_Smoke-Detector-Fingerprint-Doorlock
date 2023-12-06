#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ESP8266WebServer.h>

const char* ssid = "Redmi 9C";
const char* password = "1dua3empat5enam";

const char* serverAddress = "192.168.43.127";
const int serverPort = 80;

ESP8266WebServer server(80);

void setup() {
  Serial.begin(115200);

  // Connect to Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
  Serial.print("Local IP Address: ");
  Serial.println(WiFi.localIP());

  server.on("/", HTTP_GET, handleRoot);
  server.on("/send", HTTP_POST, handleSend);
  server.begin();
}

void loop() {
  server.handleClient();
}

void handleRoot() {
  String html = "<html><body>";
  html += "<h1>ESP8266 Web Server</h1>";
  html += "<form action='/send' method='post'>";
  html += "<input type='submit' value='Send Message'>";
  html += "</form>";

  if (server.hasArg("result")) {
    html += "<p>Result: " + server.arg("result") + "</p>";
  }

  html += "</body></html>";
  server.send(200, "text/html", html);
}

void handleSend() {
  sendPostRequest();
  server.send(302, "text/plain", "Location: /?result=success");
}

void sendPostRequest() {
  HTTPClient http;
  WiFiClient client;

  String url = String(serverAddress) + "/php/terima.php";

  Serial.print("Connecting to: ");
  Serial.println(url);

  if (http.begin(client, url)) {
    Serial.println("HTTP connection established");

    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String postMessage = "message=hello world";

    int httpResponseCode = http.POST(postMessage);

    if (httpResponseCode == HTTP_CODE_MOVED_PERMANENTLY || httpResponseCode == HTTP_CODE_FOUND) {
      String newUrl = http.header("Location");
      Serial.print("Redirected to: ");
      Serial.println(newUrl);

      http.end();
      http.begin(client, newUrl);
      httpResponseCode = http.POST(postMessage);
    }

    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);

      Serial.println(http.getString());
    } else {
      Serial.print("Error on HTTP request. Response code: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  } else {
    Serial.println("HTTP connection failed");
  }
}

