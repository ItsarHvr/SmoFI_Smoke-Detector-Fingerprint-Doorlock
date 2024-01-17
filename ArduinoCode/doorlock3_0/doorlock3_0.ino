#include <SoftwareSerial.h>
#include <Wire.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>
#include <PubSubClient.h>
#include <Adafruit_Fingerprint.h>
#include <LiquidCrystal_I2C.h>

const char* ssid = "Rumah ceria";
const char* password = "Kikiisan21";
const char* mqtt_server = "192.168.100.68";
const int mqtt_port = 1883;
const char* mqtt_username = "";
const char* mqtt_password = "";
const char* topic1 = "pbl/finger";
const char* topic2 = "EnrollID";
const char* topic3 = "pbl/relay";

WiFiClient espClient;
PubSubClient client(espClient);

SoftwareSerial mySerial(D7, D8); // RX, TX
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);
LiquidCrystal_I2C lcd(0x27, 16, 2);  // Alamat I2C LCD (0x27 adalah umumnya digunakan)

bool lastState = -1;
int relay1 = D0;
int fingerID;
int button = D4;
int relayState = HIGH;

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

  pinMode(relay1, OUTPUT);
  digitalWrite(relay1, HIGH);
  pinMode(button, INPUT_PULLUP);

  lcd.init();
  lcd.backlight();

  while (!Serial);
  delay(100);
  Serial.println("\n\nAdafruit finger detect test");

  finger.begin(57600);

  if (finger.verifyPassword()) {
    Serial.println("Found fingerprint sensor!");
  } else {
    Serial.println("Did not find fingerprint sensor :(");
    while (1) {
      delay(1);
    }
  }

  finger.getTemplateCount();
  Serial.print("Sensor contains ");
  Serial.print(finger.templateCount);
  Serial.println(" templates");
  Serial.println("Waiting for valid finger...");

  displayWaitFinger();
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

  int id = getFingerprintIDez();
  if (id == -1) {
    if (lastState == 0) {
      lastState = -1;
      displayInvalidFinger();
      sendFingerprintID(0);
      delay(2000);
      displayWaitFinger();
    }
  } else if (id != -1) {
    digitalWrite(relay1, LOW);
    sendFingerprintID(id);
    displayFingerOK();
    delay(2000);
    displayWaitFinger();
    digitalWrite(relay1, HIGH);
  }

  int buttonState = digitalRead(button); // read new state

  if (buttonState == LOW) {
    // Change the state of the relay
    if (relayState == HIGH) {
      relayState = LOW;
    } else {
      relayState = HIGH;
    }

    digitalWrite(relay1, relayState);
    sendRelayStatus();
    delay(1000);
  }

  delay(50);
}

void connectToMQTT() {
  while (!client.connected()) {
    Serial.println("Connecting to MQTT...");
    if (client.connect("ESP8266Client", mqtt_username, mqtt_password)) {
      Serial.println("Connected to MQTT broker");
      client.subscribe(topic1);
      client.subscribe(topic2);
      client.subscribe(topic3);
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

  if (strcmp(topic, topic2) == 0) {
    StaticJsonDocument<256> doc;
    deserializeJson(doc, payload);

    uint8_t id = doc["id"];
    enrollFingerprint(id);
  } else if (strcmp(topic, topic3) == 0) {
    StaticJsonDocument<256> doc;
    deserializeJson(doc, payload);
    int statusRelay = doc["statusRelay"];

    Serial.print("Received Relay Status: ");
    Serial.println(statusRelay);

  // Control the relay based on the received status
  digitalWrite(relay1, statusRelay == 0 ? HIGH : LOW);
  }
}

void sendFingerprintID(int fingerprintID) {
  connectToMQTT();
  String jsonPayload = "{\"fingerprintId\":" + String(fingerprintID) + "}";
  client.publish(topic1, jsonPayload.c_str());

  Serial.println("Fingerprint ID sent to EMQX for door unlocking!");
}

void sendRelayStatus() {
  connectToMQTT();
  int mqttRelayState = (relayState == HIGH) ? 1 : 0;

  String jsonPayload = "{\"statusRelay\":" + String(mqttRelayState) + "}";
  client.publish(topic3, jsonPayload.c_str());

  Serial.println("Relay status sent to MQTT broker!");
}

uint8_t getFingerprintID() {
    uint8_t p = finger.getImage();
    switch (p) {
        case FINGERPRINT_OK:
            Serial.println("Image taken");
            break;
        case FINGERPRINT_NOFINGER:
            Serial.println("No finger detected");
            return p;
        case FINGERPRINT_PACKETRECIEVEERR:
            Serial.println("Communication error");
            return p;
        case FINGERPRINT_IMAGEFAIL:
            Serial.println("Imaging error");
            return p;
        default:
            Serial.println("Unknown error");
            return p;
    }

    // OK success!
    p = finger.image2Tz();
    switch (p) {
        case FINGERPRINT_OK:
            Serial.println("Image converted");
            break;
        case FINGERPRINT_IMAGEMESS:
            Serial.println("Image too messy");
            return p;
        case FINGERPRINT_PACKETRECIEVEERR:
            Serial.println("Communication error");
            return p;
        case FINGERPRINT_FEATUREFAIL:
            Serial.println("Could not find fingerprint features");
            return p;
        case FINGERPRINT_INVALIDIMAGE:
            Serial.println("Could not find fingerprint features");
            return p;
        default:
            Serial.println("Unknown error");
            return p;
    }

    // OK converted!
    p = finger.fingerFastSearch();
    if (p == FINGERPRINT_OK) {
        Serial.println("Found a print match!");
    } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
        Serial.println("Communication error");
        return p;
    } else if (p == FINGERPRINT_NOTFOUND) {
        Serial.println("Did not find a match");
        return p;
    } else {
        Serial.println("Unknown error");
        return p;
    }   

    // Found a match!
    Serial.print("Found ID #"); Serial.print(finger.fingerID);
    Serial.print(" with confidence of "); Serial.println(finger.confidence); 
    return finger.fingerID;
}

int getFingerprintIDez() {
    uint8_t p = finger.getImage();
    Serial.println(p);
    if (p == 0) {
        lastState = 0;
    }

    if (p != FINGERPRINT_OK)  return -1;

    p = finger.image2Tz();
    if (p != FINGERPRINT_OK)  return -1;

    p = finger.fingerFastSearch();
    if (p != FINGERPRINT_OK)  return -1;

    lastState = 1;

    // Found a match!
    Serial.print("Found ID #"); Serial.print(finger.fingerID);
    Serial.print(" with confidence of "); Serial.println(finger.confidence);
    return finger.fingerID; 
}

void displayWaitFinger() {
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("PUT YOUR FINGER");
    lcd.setCursor(0, 1);
    lcd.print("ON THE SCANNER");
}

void displayInvalidFinger() {
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("FINGER");
    lcd.setCursor(0, 1);
    lcd.print("NOT FOUND!!!");
}

void displayFingerOK() {
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("WELCOME ");
    lcd.setCursor(0, 1);
    lcd.print("DOOR UNLOCK");
}

void enrollFingerprint(uint8_t id) {
  Serial.println("Ready to enroll a fingerprint!");
  Serial.print("Enrolling ID #");
  Serial.println(id);

  while (!getFingerprintEnroll(id));
}

uint8_t getFingerprintEnroll(uint8_t id) {
  int p = -1;
  Serial.print("Waiting for valid finger to enroll as #");
  Serial.println(id);
  
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image taken");
        break;
      case FINGERPRINT_NOFINGER:
        Serial.println(".");
        break;
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        break;
      case FINGERPRINT_IMAGEFAIL:
        Serial.println("Imaging error");
        break;
      default:
        Serial.println("Unknown error");
        break;
    }
  }

  p = finger.image2Tz(1);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  Serial.println("Remove finger");
  delay(2000);
  p = 0;
  while (p != FINGERPRINT_NOFINGER) {
    p = finger.getImage();
  }
  Serial.print("ID ");
  Serial.println(id);
  p = -1;
  Serial.println("Place same finger again");
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image taken");
        break;
      case FINGERPRINT_NOFINGER:
        Serial.print(".");
        break;
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        break;
      case FINGERPRINT_IMAGEFAIL:
        Serial.println("Imaging error");
        break;
      default:
        Serial.println("Unknown error");
        break;
    }
  }

  p = finger.image2Tz(2);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  Serial.print("Creating model for #");
  Serial.println(id);

  p = finger.createModel();
  if (p == FINGERPRINT_OK) {
    Serial.println("Prints matched!");
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_ENROLLMISMATCH) {
    Serial.println("Fingerprints did not match");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }

  Serial.print("ID ");
  Serial.println(id);
  p = finger.storeModel(id);
  if (p == FINGERPRINT_OK) {
    Serial.println("Stored!");
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_BADLOCATION) {
    Serial.println("Could not store in that location");
    return p;
  } else if (p == FINGERPRINT_FLASHERR) {
    Serial.println("Error writing to flash");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }

  return true;
}
