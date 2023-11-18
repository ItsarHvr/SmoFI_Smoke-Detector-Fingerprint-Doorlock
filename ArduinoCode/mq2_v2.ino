const int mq2Pin = A0; // Hubungkan pin sensor ke pin A0 pada NodeMCU atau sesuaikan dengan konfigurasi Anda

void setup() {
  Serial.begin(9600);
  pinMode(mq2Pin, INPUT);
}

void loop() {
  // Baca nilai sensor MQ-2
  int mq2Value = analogRead(mq2Pin);

  // Cetak nilai ke Serial Monitor
  Serial.print("MQ2 Value: ");
  Serial.println(mq2Value);

  delay(1000); // Tunggu 1 detik sebelum membaca nilai sensor lagi
}
