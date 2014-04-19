#include <PinChangeInt.h>
#include <Keypad.h>
#define NO_PORTB_PINCHANGES
#define NO_PORTD_PINCHANGES
#define NO_PIN_STATE
#define NO_PIN_NUMBER

long prevTime = 0;
volatile int int_code = 0;
char pass[4];
int count = 0;
int attempts = 0;
boolean isBlocked = false;

const byte ROWS = 4;
const byte COLS = 3;
char keys[ROWS][COLS] = {
{'1','2','3'},
{'4','5','6'},
{'7','8','9'},
{'*','0','#'}};

byte rowPins[ROWS] = {2, 3, 4, 5};
byte colPins[COLS] = {6, 7, 8};

Keypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS );

void outside_source() {
  Serial.println("Out");
  int_code = 1;
}

void inside_source() {
  int_code = 2;
}

void setup(){
  Serial.begin(9600);
  Serial.println("PinChangeInt test on pin A3");
  pinMode(A3, INPUT);
  digitalWrite(A3, HIGH);
  PCintPort::attachInterrupt(A3, &outside_source, RISING);
}

void loop(){
  unsigned long curTime = millis();
  if(curTime - prevTime > 30000 && isBlocked){
    prevTime = curTime;
    isBlocked = false;
  }
  
  if(int_code == 0){
    //Check Server
  }
  else if(int_code == 1){
    //Idle check
    if(curTime - prevTime > 10000 && !isBlocked){
      prevTime = curTime;
      attempts = 0;
      int_code = 0;
    }
    //Block check
    if(isBlocked){
      Serial.println("Blocked");
      Serial.print("Wait for ");
      Serial.print((curTime - prevTime)/1000);
      Serial.println(" second");
      delay(1000);
      int_code = 0;
    }
    char key = keypad.getKey();
    if (key != NO_KEY){
      Serial.print(key);
      pass[count] = key;
      count++;
      if(count >= 4){
        attempts++;
        pass[count] = '\0';
        String pswd(pass);
        pass_init();
        if(pswd == "1234"){
          attempts = 0;
          open_door();
        }
        else{
          prevTime = curTime;
          Serial.println("Salah");
          if(attempts >= 3){
            attempts = 0;
            isBlocked = true;
            int_code = 0;
            Serial.println("Wait for 30 seconds");
          }
        }
      }
    }
  }
  else if(int_code == 2){
    Serial.println("Pintu terbuka");
    open_door();
  }
}

void pass_init(){
  memset(pass, 0, sizeof pass);
  count = 0;
}

void open_door(){
  Serial.println("Door open");
  delay(4000);
  Serial.println("Door close");
  int_code = 0;
}



