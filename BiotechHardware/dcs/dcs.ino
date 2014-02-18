#include <SPI.h>
#include <Ethernet.h>
#include <Keypad.h>
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>
#include <Servo.h>
#include <HttpClient.h>
#include <EthernetClient.h>

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


const char server[] = "192.168.1.3";
byte mac[] = {0x90, 0xA2, 0xDA, 0x0E, 0xF5, 0x30};
IPAddress ip(192,168,4,3);

const int sensor = A0;

int attempt = 0;
int count = 0;
String disp = "";
char pass[255];

void setup(){
  Serial.begin(9600);
  lcd.init();
  lcd.backlight();
  lcd.setCursor(3, 0);
  lcd.print("Danz  Security");
  lcd.setCursor(0,1);
  lcd.print("Initializing...");
  lcd_init();
  Ethernet.begin(mac, ip);
  pinMode(sensor, INPUT);
  digitalWrite(sensor, HIGH);
}

void loop(){
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
  int result = read_server("/api/dcs_get_result").toInt();
  if(result == 1){
    lcd_print("Pintu Terbuka");
    delay(2000);
  }else{
    lcd_print("Password Salah");
    delay(2000);
  }
}

String read_server(char url[]){
  int err = 0;
  int stringPos = 0; 
  char inString[32];
  memset( &inString, 0, 32 );
  EthernetClient c;
  HttpClient http(c);
  err = http.get(server, url);
  if (err == 0){
    http.skipResponseHeaders();
    int bodyLen = http.contentLength();
    char c;
    while ((http.connected() || http.available())){
      if (http.available()){
        c = http.read();
        inString[stringPos] = c;
        stringPos ++;
        bodyLen--;
      }
    }
    return inString;
  }
}
