const int mq2Pin = A0;
const int buzzerPin = 23; // Ganti dengan pin digital yang Anda gunakan
const int ambangNilai = 50; // Sesuaikan dengan nilai ambang yang Anda tentukan


void setup() {
  Serial.begin(9600);
  pinMode(mq2Pin, INPUT);
  pinMode(buzzerPin, OUTPUT);
}

void loop() {
  int mq2Value = analogRead(mq2Pin);

  Serial.print("MQ2 Value: ");
  Serial.println(mq2Value);

  // Jika nilai MQ2 melebihi ambang tertentu, aktifkan buzzer
  if (mq2Value > ambangNilai) {
    digitalWrite(buzzerPin, HIGH); // Aktifkan buzzer
    delay(500); // Tahan buzzer selama 0.5 detik
    digitalWrite(buzzerPin, LOW); // Matikan buzzer
    delay(500); // Tunggu selama 0.5 detik sebelum membaca nilai MQ2 lagi
  } else {
    digitalWrite(buzzerPin, LOW); // Matikan buzzer jika nilai MQ2 tidak melebihi ambang
    delay(1000); // Tunggu selama 1 detik sebelum membaca nilai MQ2 lagi
  }
}
