#include <RCSwitch.h>
#include <DHT.h>

#define DHTPIN 2
#define DHTTYPE DHT11

DHT dht(DHTPIN, DHTTYPE);
RCSwitch mySwitch = RCSwitch();

long long data = 0;
int t = 1; //time to send
long id = 1,doam,nhietdo; //sensor id
int ctime;

void setup() {
  mySwitch.enableTransmit(10); //pin 10
  dht.begin();
}

void loop() {
  ctime = gettime(millis());

  if (ctime == t) {
    doam = round(dht.readHumidity());
    nhietdo = round(dht.readTemperature());
    
    data = 0B000000000000000000000000;
    data = data | (id << 20);
    data = data | (nhietdo << 10);
    data = data | doam;

    mySwitch.send(data,24);
  }
  
  delay(1000);
}

int gettime(long long d) {
  data = round(d/1000);
  while (d > 10) {
    d = d % 10;
  } 

  return d;
}



