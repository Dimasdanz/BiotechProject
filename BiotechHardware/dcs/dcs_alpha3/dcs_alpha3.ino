#include <utility/w5100.h>
#include <SPI.h>
#include <Ethernet.h>
#include <Keypad.h>
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>
#include <Servo.h>

const char server[] = "192.168.2.4";
byte mac[] = {0x90, 0xA2, 0xDA, 0x0E, 0xF5, 0xF8};
IPAddress ip(192,168,1,5);

EthernetClient client;

const byte ROWS = 4;
const byte COLS = 3;
char keys[ROWS][COLS] = {
  {'1','2','3'},{'4','5','6'},{'7','8','9'},{'*','0','#'}
};

byte rowPins[ROWS] = {2, 3, 4, 5};
byte colPins[COLS] = {6, 7, 8};

Keypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS );
LiquidCrystal_I2C lcd(0x27,20,4);
Servo myservo;

const int sensor = A2;
const int push_btn = A3;
const int servo = 9;

int attempt = 0;
int count = 0;
int max_attempt;
String disp = "";
char pass[16];

boolean display_armed = false;
boolean display_disarmed = false;
boolean display_locked = false;
boolean display_unlocked = false;
boolean display_offline = false;
boolean display_online = false;

boolean device_status;
boolean device_condition;

long prevTime = 0;
long interval_check = 60000;

void setup(){
  Serial.begin(9600);
  myservo.attach(9);
  Ethernet.begin(mac, ip);
  
  Serial.println(Ethernet.localIP());
  
  W5100.setRetransmissionTime(0x07D0);
  W5100.setRetransmissionCount(3);
  
  lcd.init();
  lcd.backlight();
  lcd.setCursor(3, 0);
  lcd.print("Keamanan Pintu");
  lcd.setCursor(0,1);
  lcd.print("Inisialisasi");
  
  device_status = check_device();
  device_condition = check_condition();
  
  lcd_init();
  pinMode(sensor, INPUT);
  digitalWrite(sensor, HIGH);
  pinMode(push_btn, INPUT);
  digitalWrite(push_btn, HIGH);
  myservo.write(70);
}

void loop(){
  unsigned long curTime = millis();
  
  if(curTime - prevTime > interval_check){
    prevTime = curTime;
    device_status = check_device();
    device_condition = check_condition();
  }
  
  if(digitalRead(push_btn) == LOW){
    open_door();
    lcd_init();
  }
  
  if(device_status){
    if(device_condition){
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
    }
    else{
      device_status = check_device();
      device_condition = check_condition();
    }
  }else{
    device_status = check_device();
    device_condition = check_condition();
  }
}

boolean check_device(){
  Serial.print("Cek Status");
  String a = read_server("/api/dcs/dcs_get_value/status");
  if(a == "1"){
    if(!display_armed){
      lcd_init();
      lcd_offline(false);
      display_armed = true;
    }
    Serial.println("Status True");
    display_disarmed = false;
    display_offline = false;
    return true;
  }else if(a == "2"){
    if(!display_offline){
      lcd_offline(true);
      display_offline = true;
    }
    display_disarmed = false;
    display_armed = false;
    return true;
  }else{
    if(!display_disarmed){
      lcd_print("Perangkat non-aktif");
      lcd_offline(false);
      display_disarmed = true;
    }
    Serial.println("Status False");
    display_armed = false;
    display_offline = false;
    return false;
  }
}

boolean check_condition(){
  Serial.print("Cek Kondisi");
  String a = read_server("/api/dcs/dcs_get_value/condition");
  if(a == "0"){
    if(!display_unlocked){
      lcd_init();
      lcd_offline(false);
      display_unlocked = true;
    }
    Serial.println("Kondisi True");
    display_locked = false;
    display_offline = false;
    return true;
  }else if(a == "2"){
    if(!display_offline){
      lcd_offline(true);
      display_offline = true;
    }
    display_locked = false;
    display_unlocked = false;
    return true;
  }else{
    if(!display_locked){
      lcd_print("Perangkat terkunci");
      lcd_offline(false);
      display_locked = true;
    }
    Serial.println("Kondisi False");
    display_unlocked = false;
    display_offline = false;
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
  lcd.print("Keamanan Pintu");
  lcd.setCursor(0,1);
  lcd.print("Kata Kunci :");
  lcd.setCursor(0,2);
  for(int i=0;i<20;i++){
    lcd.print(" ");
  }
}

void lcd_offline(boolean b){
  if(b){
    lcd.setCursor(19,0);
    lcd.print("*");
  }else{
    lcd.setCursor(19,0);
    lcd.print(" ");
  }
}

void lcd_print(String s){
  lcd.clear();
  lcd.setCursor(3,0);
  lcd.print("Keamanan Pintu");
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
    client.print("POST /api/dcs/dcs_check_password HTTP/1.1\n");
    client.print("Host: 192.168.2.4\n");
    client.print("Connection: close\n");
    client.print("Content-Type: application/x-www-form-urlencoded\n");
    client.print("Content-Length: ");
    client.print(data.length());
    client.print("\n\n");
    client.print(data);
    
    delay(50);
    check_result(read_server("/api/dcs/dcs_get_value/result"));
  }else{
    Serial.println("Sending... Server offline");
    String pass(password);
    Serial.println(pass);
    if(pass == "01234*"){
      check_result("1");
    }else{
      check_result("0");
    }
  }
}

void check_result(String result){
  Serial.println(result);
  if(attempt == 1){
    max_attempt = read_server("/api/dcs/dcs_get_value/password_attempts").toInt();
    lcd_attempts(attempt, max_attempt);
  }
  if(result == "1"){
      open_door();
  }else{
    lcd_print("Password Salah");
    lcd_attempts(attempt, max_attempt);
    delay(1000);
    if(max_attempt > 0){
      if(attempt >= max_attempt){
        attempt = 0;
        lock_device();
      }
    }
  }
}

void open_door(){
  attempt = 0;
  lcd_print("Pintu Terbuka");
  myservo.write(30);
  delay(3000);
  int val = digitalRead(sensor);
  while(digitalRead(sensor) == HIGH){
    val = digitalRead(sensor);
  }
  delay(1000);
  myservo.write(70);
}

String read_server(String url){
  if (client.connect(server, 80)) {
    client.print("GET ");
    client.println(url);
    client.println();
    return readData();
  }
  else{
    Serial.println("Reading... Server offline");
    return "2";
  }
}

String readData(){
  int stringPos = 0; 
  boolean startRead = false;
  char inString[8];

  memset( &inString, 0, 8 );
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
    client.print("POST /api/dcs/dcs_lock HTTP/1.1\n");
    client.print("Host: 192.168.2.4\n");
    client.print("Connection: close\n");
    client.print("Content-Type: application/x-www-form-urlencoded\n");
    client.print("Content-Length: ");
    client.print(data.length());
    client.print("\n\n");
    client.print(data);
    
    device_condition = false;
  }
}

