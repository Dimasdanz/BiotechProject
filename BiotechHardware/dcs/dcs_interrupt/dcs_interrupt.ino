#include <PinChangeInt.h>
#include <Keypad.h>
#define NO_PORTB_PINCHANGES
#define NO_PORTD_PINCHANGES
#define NO_PIN_STATE
#define NO_PIN_NUMBER

long prevTime = 0;
volatile boolean interrupted = false;

const byte ROWS = 4;
const byte COLS = 3;
char keys[ROWS][COLS] = {
  {
    '1','2','3'  }
  ,
  {
    '4','5','6'  }
  ,
  {
    '7','8','9'  }
  ,
  {
    '*','0','#'  }
};

byte rowPins[ROWS] = {
  2, 3, 4, 5};
byte colPins[COLS] = {
  6, 7, 8};

Keypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS );

void quicfunc() {
  Serial.println("Test");
  interrupted = true;
}

void setup(){
  Serial.begin(9600);
  Serial.println("PinChangeInt test on pin A3");
  pinMode(A3, INPUT);
  digitalWrite(A3, HIGH);
  digitalWrite(5, HIGH);
  PCintPort::attachInterrupt(5, &quicfunc, RISING);
}

void loop(){
  char key = keypad.getKey();
  if (key != NO_KEY){
    Serial.print(key);
  }
}



