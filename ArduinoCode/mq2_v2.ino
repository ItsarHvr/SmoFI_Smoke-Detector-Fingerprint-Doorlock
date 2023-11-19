const int mq2Pin = A0;

void setup() {
  Serial.begin(9600);
  pinMode(mq2Pin, INPUT);
}

void loop() {
  int mq2Value = analogRead(mq2Pin);

  Serial.print("MQ2 Value: ");
  Serial.println(mq2Value);

  delay(1000);
}
