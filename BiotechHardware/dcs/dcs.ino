#include <SPI.h>
#include <Ethernet.h>
#include <Keypad.h>
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>
#include <Servo.h>

const byte ROWS = 4;
const byte COLS = 3;
char keys[ROWS][COLS] = {
  {'1','2','3'},
  {'4','5','6'},
  {'7','8','9'},
  {'*','0','#'}
};

byte rowPins[ROWS] = {2, 3, 4, 5};
byte colPins[COLS] = {6, 7, 8};

Keypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS );
LiquidCrystal_I2C lcd(0x27,20,4);
EthernetClient client;

const char server[] = "192.168.1.3";
byte mac[] = {0x90, 0xA2, 0xDA, 0x0E, 0xF5, 0x30};
IPAddress ip(192,168,4,3);

const int sensor = A2;

int attempt = 0;
int count = 0;
int max_attempt;
String disp = "";
char pass[255];

boolean display_armed = false;
boolean display_disarmed = false;
boolean display_locked = false;
boolean display_unlocked = false;

void setup(){
  lcd.init();
  lcd.backlight();
  lcd.setCursor(3, 0);
  lcd.print("Danz  Security");
  lcd.setCursor(0,1);
  lcd.print("Inisialisasi...");
  Ethernet.begin(mac, ip);
  check_device();
  lcd_init();
  pinMode(sensor, INPUT);
  digitalWrite(sensor, HIGH);
}

void loop(){
  if(check_device()){
    if(check_condition()){
      char key = keypad.getKey();
      if (key != NO_KEY){
        disp += "*";
        lcd.setCursor(0,2);
        lcd.print(disp);
        pass[count] = key;
        count++;
      }
      if(key == '*'){
        attempt++;
        send_password(pass);
        sys_init();
        lcd_init();
      }
      if(key == '#'){
        sys_init();
        lcd_init();
      }
    }else{
      //check_condition();
    }
  }
}

boolean check_device(){
  if(read_server("/api/dcs_get_value/status") == "1"){
    if(!display_armed){
      lcd_init();
      display_armed = true;
    }
    display_disarmed = false;
    return true;
  }else{
    if(!display_disarmed){
      lcd_print("Perangkat non-aktif");
      display_disarmed = true;
    }
    display_armed = false;
    return false;
  }
}

boolean check_condition(){
  if(read_server("/api/dcs_get_value/condition") == "0"){
    if(!display_unlocked){
      lcd_init();
      display_unlocked = true;
    }
    display_locked = false;
    return true;
  }else{
    if(!display_locked){
      lcd_print("Perangkat terkunci");
      display_locked = true;
    }
    display_unlocked = false;
    return false;
  }
}

void sys_init(){
  memset(pass, 0, sizeof pass);
  count = 0;
  disp = "";
}

void lcd_init(){
  lcd.setCursor(3,0);
  lcd.print("Danz  Security");
  lcd.setCursor(0,1);
  lcd.print("Input Password :");
  lcd.setCursor(0,2);
  for(int i=0;i<20;i++){
    lcd.print(" ");
  }
}

void lcd_print(String s){
  lcd.clear();
  lcd.setCursor(3,0);
  lcd.print("Danz  Security");
  lcd.setCursor(0,2);
  lcd.print(s);
}

void lcd_attempts(int tried, int attempts){
  lcd.setCursor(0,3);
  lcd.print("Percobaan :");
  lcd.setCursor(13,3);
  lcd.print(tried);
  lcd.setCursor(15,3);
  lcd.print("/");
  lcd.print(attempts);
}

void send_password(char password[]){
  String data ="";
  EthernetClient client;
  String s_password = "password=";
  data = s_password+password;
  Serial.println(data);

  if (client.connect(server,80))
  {
    client.print("POST /api/dcs_check_password HTTP/1.1\n");
    client.print("Host: 192.168.1.3\n");
    client.print("Connection: close\n");
    client.print("Content-Type: application/x-www-form-urlencoded\n");
    client.print("Content-Length: ");
    client.print(data.length());
    client.print("\n\n");
    client.print(data);
  }
  delay(50);
  check_result(read_server("/api/dcs_get_value/result"));
}

void check_result(String result){
  if(attempt == 1){
    max_attempt = read_server("/api/dcs_get_value/password_attempts").toInt();
    lcd_attempts(attempt, max_attempt);
  }
  if(result == "1"){
    attempt = 0;
    lcd_print("Pintu Terbuka");
    delay(3000);
    int val = digitalRead(sensor);
    while(digitalRead(sensor) == HIGH){
      val = digitalRead(sensor);
    }
    delay(1000);
  }else{
    lcd_print("Password Salah");
    lcd_attempts(attempt, max_attempt);
    delay(1000);
    if(attempt >= max_attempt){
      attempt = 0;
      lock_device();
    }
  }
}

String read_server(String url){
  if (client.connect(server, 80)) {
    client.print("GET ");
    client.println(url);
    client.println();
    return readData();
  }
  else{
    return "connection failed";
  }
}

String readData(){
  int stringPos = 0; 
  boolean startRead = false;
  char inString[32];

  memset( &inString, 0, 32 );
  while(true){
    if (client.available()) {
      char c = client.read();
      if (c == '<' ) {
        startRead = true;
      }
      else if(startRead){
        if(c != '>'){
          inString[stringPos] = c;
          stringPos ++;
        }
        else{
          startRead = false;
          client.stop();
          client.flush();
          return inString;
        }
      }
    }
  }
}

void lock_device(){
  String data ="";
  EthernetClient client;
  data = "1";

  if (client.connect(server,80))
  {
    client.print("POST /api/dcs_lock HTTP/1.1\n");
    client.print("Host: 192.168.1.3\n");
    client.print("Connection: close\n");
    client.print("Content-Type: application/x-www-form-urlencoded\n");
    client.print("Content-Length: ");
    client.print(data.length());
    client.print("\n\n");
    client.print(data);
  }
}
