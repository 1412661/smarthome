#include <RCSwitch.h>
RCSwitch mySwitch = RCSwitch();

int temp,sensor = A0;
int max_temp = 40;
int t = 6;

long long data1,data2;

void setup() {
  mySwitch.enableTransmit(10);
  data1 = 0B000000000000110011110000;
  data2 = 0B000000000000110011000000;
}

void loop() {
  if (gettime(millis()) == t) {
    temp = round((5.0*analogRead(sensor)*100.0/1024.0));
    if (temp > max_temp) mySwitch.send(data1,24);
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





