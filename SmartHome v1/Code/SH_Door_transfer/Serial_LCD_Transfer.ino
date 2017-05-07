#include <Button.h>

Button ENTER = Button(12,PULLUP);
Button CLEAR = Button(13,PULLUP);

int de = 200;

Button button[10] = {
  Button(2,PULLUP),
  Button(3,PULLUP),
  Button(4,PULLUP),
  Button(5,PULLUP),
  Button(6,PULLUP),
  Button(7,PULLUP),
  Button(8,PULLUP),
  Button(9,PULLUP),
  Button(10,PULLUP),
  Button(11,PULLUP)
  };


  void setup(){
    Serial.begin(115200);
    for (byte i = 2; i<=13; i++) {
      pinMode(i, OUTPUT); 
    }
  }

void loop(){
  if(ENTER.isPressed()){
    Serial.println("ENTER");
    delay(de);
  }

  if(CLEAR.isPressed()){
    Serial.println("CLEAR");
    delay(de);
  }

  if (button[0].isPressed()) {
    Serial.println("PUSH 1");
    delay(de);
  }

  if (button[1].isPressed()) {
    Serial.println("PUSH 2");
    delay(de);
  }

  if (button[2].isPressed()) {
    Serial.println("PUSH 3");
    delay(de);
  }

  if (button[3].isPressed()) {
    Serial.println("PUSH 4");
    delay(de);
  }

  if (button[4].isPressed()) {
    Serial.println("PUSH 5");
    delay(de);
  }

  if (button[5].isPressed()) {
    Serial.println("PUSH 6");
    delay(de);
  }

  if (button[6].isPressed()) {
    Serial.println("PUSH 7");
    delay(de);
  }

  if (button[7].isPressed()) {
    Serial.println("PUSH 8");
    delay(de);
  }

  if (button[8].isPressed()) {
    Serial.println("PUSH 9");
    delay(de);
  }

  if (button[9].isPressed()) {
    Serial.println("PUSH 0");
    delay(de);
  }
}





