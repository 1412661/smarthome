#define F_CPU 9000000L
#define STK500 false

#include <inttypes.h>
#include <avr/io.h>
#include <util/delay.h>
#include <avr/pgmspace.h>

#ifndef cbi
#define cbi(sfr, bit) (_SFR_BYTE(sfr) &= ~_BV(bit))
#endif
#ifndef sbi
#define sbi(sfr, bit) (_SFR_BYTE(sfr) |= _BV(bit))
#endif 

void digitalWrite_(uint8_t pin, uint8_t val) {
  if (val)
    PORTB = sbi(PORTB, pin);
  else
    PORTB = cbi(PORTB, pin);
}

void delay_(uint16_t milliseconds) {
  for(; milliseconds>0; milliseconds--) _delay_ms(1);
}

word analogRead_(byte pin)  {  //ADC pin 
  ADMUX |= (0 << REFS0);
  ADMUX = pin;  
  ADCSRA |= (1 << ADSC);
  while((ADCSRA & 0x40) !=0){
  }; 
  return ADC;
} 

void analogWrite_(byte pin, byte power) {    // PBx pin
  DDRB |= (1<<pin);

#if STK500
  TCCR0A = (1<<WGM01)|(1<<WGM00)|(1<<COM0A1)|(1<<COM0A0);
#else
  TCCR0A = (1<<WGM01)|(1<<WGM00)|(1<<COM0A1)|(0<<COM0A0);
#endif
  TCCR0B = (1<<CS00);

  OCR0A = power;
}

/*************************************************
 * FUNCTION LIST:
 * 
 * digitalWrite_();
 * delay_();
 * analogRead_();
 * analogWrite_();
 *************************************************/
int laze = 1; //ADC1 -> PB2
int pir = PB1;
int speaker = PB0;

int laze_r,pir_r;

void setup() {
  pinMode(speaker, OUTPUT);
  digitalWrite(speaker, HIGH);
  delay(200);
  digitalWrite(speaker, LOW);
}

void loop() {
  pir_r = digitalRead(pir);
  laze_r = analogRead_(laze); 
  if ((pir_r == 1) | laze_r > 222) buzz();
  delay(100);
}

void buzz() {
  for (int i = 1; i<= 10;i++) {
    digitalWrite(speaker, HIGH);
    delay(100);
    digitalWrite(speaker, LOW);
    delay(100);
  } 
}







