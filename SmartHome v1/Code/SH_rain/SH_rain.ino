#include <RCSwitch.h>

RCSwitch mySwitch = RCSwitch();

int t = 3;

int rain = A0,rain_r;
long long data1,data2;

void setup() {
  mySwitch.enableTransmit(10);
  data1 = 3087; //0B000000000000110000001111
  data2 = 3084; //0B000000000000110000001100
}

void loop() {
  if (gettime(millis()) == t) {
    if (analogRead(rain) < 410) mySwitch.send(data1,24);
    else mySwitch.send(data2,24);
  }

  delay(1000);
}

int gettime(unsigned long data) {
  data = round(data/1000);
  while (data > 10) {
    data = data % 10;
  } 

  return data;
}

