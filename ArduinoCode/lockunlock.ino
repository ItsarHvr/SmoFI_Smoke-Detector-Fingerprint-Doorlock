#define BLYNK_PRINT Serial
#define BLYNK_TEMPLATE_ID "TMPL6ybVzH-29"
#define BLYNK_TEMPLATE_NAME "DoorLock"
#define BLYNK_AUTH_TOKEN "OO745NTxENRvKcQ256RHEgKHQtBDdFl5"
#define WIFI_SSID "Smartfren 2rb/Gb"
#define WIFI_PASS "123443211234"
#include <ESP8266WiFi.h>
#include <BlynkSimpleEsp8266.h>
#include <Adafruit_Fingerprint.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <SoftwareSerial.h>

SoftwareSerial mySerial(D2, D3); // RX, TX
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);

LiquidCrystal_I2C lcd(0x27, 16, 2);  // I2C LCD Address (0x27 is commonly used)

int relayPin = D0;
bool lastState = -1;
int relayState = HIGH;  // Initial relay state (HIGH means door locked)

void setup() {
  pinMode(relayPin, OUTPUT);
  digitalWrite(relayPin, relayState);

  lcd.init();
  lcd.backlight();

  Serial.begin(9600);
  while (!Serial);
  delay(100);
  Serial.println("\n\nAdafruit finger detect test");

  finger.begin(57600);

  if (finger.verifyPassword()) {
    Serial.println("Found fingerprint sensor!");
  } else {
    Serial.println("Did not find fingerprint sensor :(");
    while (1) { delay(1); }
  }

  finger.getTemplateCount();
  Serial.print("Sensor contains "); Serial.print(finger.templateCount); Serial.println(" templates");
  Serial.println("Waiting for a valid finger...");

  displayWaitFinger();
  
  // Initialize Blynk connection
  Blynk.begin(BLYNK_AUTH_TOKEN, WIFI_SSID, WIFI_PASS);
}

void loop() {
  Blynk.run();

  int fingerprintID = getFingerprintIDez();
  
  if (fingerprintID != -1) {
    if (relayState == HIGH) {
      // Door is locked, unlock it
      relayState = LOW;
      digitalWrite(relayPin, relayState);
      Blynk.virtualWrite(V0, 1); // Update Blynk button state
      displayFingerOK();
      delay(2000);
      displayWaitFinger();
    } else {
      // Door is unlocked, lock it
      relayState = HIGH;
      digitalWrite(relayPin, relayState);
      Blynk.virtualWrite(V0, 0); // Update Blynk button state
      displayFingerOK();
      delay(2000);
      displayWaitFinger();
    }
  }
  delay(50);
}

BLYNK_WRITE(V0)
{
  // Mendapatkan nilai tombol virtual (1 atau 0)
  int relayState = param.asInt();

  // Mengendalikan relay sesuai nilai tombol virtual (balik logika)
  digitalWrite(relayPin, !relayState);

  // Mengirimkan status relay ke Blynk
  Blynk.virtualWrite(V0, relayState);
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
