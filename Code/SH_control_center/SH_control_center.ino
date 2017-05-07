#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <RCSwitch.h>

RCSwitch mySwitch = RCSwitch();
LiquidCrystal_I2C lcd(0x27,16,2);

#if defined(ARDUINO) && ARDUINO >= 100
#define printByte(args)  write(args);
#else
#define printByte(args)  print(args,BYTE);
#endif

long long data,t;
int b1,b2 = -100,b3 = -100,rain,fire;

int fire1 = 3,fire2 = 4, rain1 = 5,rain2 = 6;

int press1 = 7,press2 = 8;

uint8_t degree[8] = {
  0B00111,
  0B00101,
  0B00111,
  0B00000,
  0B00000,
  0B00000,
  0B00000,
  0B00000
};

void setup() {
  lcd.init(); 
  lcd.backlight();
  lcd.createChar(0, degree); //printByte(0);
  welcome();
  pinMode(fire1, INPUT);
  pinMode(fire2, INPUT);
  pinMode(rain1, INPUT);
  pinMode(rain2, INPUT);
  pinMode(press1, INPUT_PULLUP);
  pinMode(press2, INPUT_PULLUP);
  mySwitch.enableReceive(0); //pin 2
}

void loop() {
  read_rain_fire();
  read_sensor();

  if (digitalRead(press1) == 0) show_sensor();
  else if (digitalRead(press2) == 0) show_rain_fire();
  else welcome();

  delay(5);
}

void read_sensor() {
  data = mySwitch.getReceivedValue();

  if ((data != 0) and ((data >> 20) != 0)) {
    b1 = data >> 20;
    b2 = (data >> 10) % 1024;
    t = b1 << 20;
    t |= b2 << 10;
    b3 = data - t;
  }
}

void read_rain_fire() {
  if (digitalRead(rain2) == 1) rain = digitalRead(rain1);
  if (digitalRead(fire2) == 1) fire = digitalRead(fire1);
}

void show_sensor() {
  lcd.clear();
  lcd.print("Nhiet do: ");
  if (b2 > -100) {
    lcd.print(b2);
    lcd.printByte(0);
    lcd.print("C");
  } 
  else lcd.print("...");
  lcd.setCursor(15,0);
  lcd.print(b1);
  lcd.setCursor(0,1);
  lcd.print("Do am:    ");
  if (b3 > -100) {
    lcd.print(b3);
    lcd.print("%");
  } 
  else lcd.print("...");
  delay(2000);
}

void show_rain_fire() {

  lcd.clear();
  if (rain) lcd.print("Dang mua ...");
  else lcd.print("Khong mua.");

  lcd.setCursor(0,1);
  if (fire) lcd.print("Qua nhiet do !");
  else lcd.print("Nhiet do OK.");
  delay(2000);

}

void welcome() {
  lcd.clear();
  lcd.print("WELCOME TO");
  lcd.setCursor(0,1);
  lcd.print("    SMART HOME");
  delay(2000);
}












