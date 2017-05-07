
byte sensor = PB1;
byte speaker = PB0;

void setup() {
  pinMode(sensor, INPUT);
  pinMode(speaker, OUTPUT);
}

void loop() {
  if (digitalRead(sensor) == 1) {
      for (byte i = 1; i <= 5; i++) {
        digitalWrite(speaker, HIGH);
        delay(50);
        digitalWrite(speaker, LOW);
        delay(50);
      }
  }
  
  delay(50);
}
