#include <OneWire.h>
#include <DallasTemperature.h>
#include <SPI.h>
#include <HttpClient.h>
#include <Ethernet.h>
#include <EthernetClient.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>

const int smoke_pin = A3;
const int temp_pin =  2;
const int relay = 3; 
const int fan = 9;

float percentage = 0;
int fan_speed = 255;

byte mac[] = {0x90, 0xA2, 0xDA, 0x0E, 0xF5, 0x30 };
const char server[] = "192.168.1.3";
IPAddress ip(192,168,4,3);

OneWire oneWire(temp_pin);
DallasTemperature temp_sensor(&oneWire);

LiquidCrystal_I2C lcd(0x27,20,4);

void setup() {
  lcd.init();
  lcd.backlight();
  lcd.setCursor(0, 0);
  lcd.print("Bioteknologi LIPI");
  lcd.setCursor(0, 1);
  lcd.print("Suhu :");
  lcd.setCursor(17,1);
  lcd.print((char)223);
  lcd.print("C");
  lcd.setCursor(0, 2);
  lcd.print("Asap :");
  lcd.setCursor(17,2);
  lcd.print("ppm");
  Serial.begin(9600);
  pinMode(smoke_pin, INPUT);
  temp_sensor.begin();
  Ethernet.begin(mac, ip);
  pinMode(fan, OUTPUT);
  analogWrite(fan, 255);
  delay(3000);
  pinMode(relay, OUTPUT);
  digitalWrite(relay, HIGH);
}

void loop() {
  temp_sensor.requestTemperatures();
  
  float temp = temp_sensor.getTempCByIndex(0);
  float smoke = analogRead(smoke_pin);

  if(temp > 40){
    digitalWrite(relay, LOW);
  }
  else{
    digitalWrite(relay, HIGH);
  }
  
  percentage = (smoke/1023)*100;
  smoke = percentage*10;
  fan_speed = percentage+155;
  if(percentage < 10){
    smoke = 10;
  }
  analogWrite(fan, fan_speed);
  Serial.println(smoke);  
  Serial.println(temp);
  print_lcd(temp, smoke);
  send_log(temp, smoke);
  
  delay(1000);
}

void print_lcd(float vtemp, float vsmoke){
  lcd.setCursor(7, 1);
  for(int i=0;i<6;i++){
    lcd.print(" ");
  }
  lcd.setCursor(7, 1);
  lcd.print(vtemp);
  lcd.setCursor(7, 2);
  for(int i=0;i<6;i++){
    lcd.print(" ");
  }
  lcd.setCursor(7, 2);
  lcd.print(vsmoke);
}

void send_log(float temp, float smoke){
  String data ="";
  EthernetClient client;
  String s_temp = "temp=";
  String s_smoke= "&smoke=";
  data = s_temp+temp+s_smoke+smoke;
  Serial.println(data);

  if (client.connect(server,80))
  {
    client.print("POST /api/scs_insert_log HTTP/1.1\n");
    client.print("Host: 192.168.1.3\n");
    client.print("Connection: close\n");
    client.print("Content-Type: application/x-www-form-urlencoded\n");
    client.print("Content-Length: ");
    client.print(data.length());
    client.print("\n\n");
    client.print(data);
  }
}
