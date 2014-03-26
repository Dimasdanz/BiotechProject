#include <SPI.h>
#include <HttpClient.h>
#include <Ethernet.h>
#include <EthernetClient.h>
#include <Wire.h>
#include <BH1750.h>
#include <LiquidCrystal_I2C.h>
#include <OneWire.h>
#include <DallasTemperature.h>
#include <dht11.h>

byte mac[] = {0x90, 0xA2, 0xDA, 0x0E, 0xF5, 0x30};
const char server[] = "192.168.2.4";
IPAddress ip(192,168,1,13);

LiquidCrystal_I2C lcd(0x27,20,4);

const int relay_1 = 2;
const int relay_2 = 3;
const int relay_3 = 5;
const int relay_4 = 6;

const int h_pin = A3;
const int t_pin = 9;
const int ah_pin = 8;
int commaPosition;

OneWire oneWire(t_pin);
DallasTemperature temp_sensor(&oneWire);
dht11 DHT11;

int h_lower;
int h_upper;
int l_target;
boolean fan_pump;

int BH1750address = 0x23;
byte buff[2];

void setup(){
  Serial.begin(9600);
  Ethernet.begin(mac, ip);
  Serial.println(Ethernet.localIP());
  
  pinMode(relay_1, OUTPUT);
  pinMode(relay_2, OUTPUT);
  pinMode(relay_3, OUTPUT);
  pinMode(relay_4, OUTPUT);
  
  lcd.init();
  lcd.backlight();
  lcd.setCursor(0, 0);
  lcd.print("Tanah      :      %");
  lcd.setCursor(0, 1);
  lcd.print("Cahaya     :      lx");
  lcd.setCursor(0, 2);
  lcd.print("Kelembaban :      %");
  lcd.setCursor(0, 3);
  lcd.print("Temperatur :");
  lcd.setCursor(18,3);
  lcd.print((char)223);
  lcd.setCursor(19,3);
  lcd.print("C");
  delay(1000);
}

void loop(){
  String val = get_value("/api/gcs/gcs_get_value");
  
  commaPosition = val.indexOf(';');
  h_lower = val.substring(0,commaPosition).toInt();
  val = val.substring(commaPosition+1, val.length());
  Serial.println(h_lower);
  
  commaPosition = val.indexOf(';');
  h_upper = val.substring(0,commaPosition).toInt();
  Serial.println(h_upper);
  
  l_target = val.substring(commaPosition+1, val.length()).toInt();
  Serial.println(l_target);
  
  BH1750_Init(BH1750address);
  delay(200);
  int lux;
  if(2==BH1750_Read(BH1750address)){
    lux = ((buff[0]<<8)|buff[1])/1.2;
    Serial.print("Light: ");
    Serial.print(lux);
    Serial.println(" lx");
  }
  
  temp_sensor.requestTemperatures();
  float temp = temp_sensor.getTempCByIndex(0);
  Serial.println(temp);
  
  int h = constrain(analogRead(h_pin), 255, 1023);
  int soil = map(h, 255, 1023, 100, 0);
  Serial.println(soil);
  
  DHT11.read(ah_pin);
  int ah = DHT11.humidity;
  Serial.println(ah);
  
  print_lcd(lux, temp, soil, ah);
  
  if(lux < l_target){
    digitalWrite(relay_1, HIGH);
  }else{
    digitalWrite(relay_1, LOW);
  }
  
  if(soil < h_lower){
    digitalWrite(relay_2, HIGH);
  }
  
  if(soil > h_upper){
    digitalWrite(relay_2, LOW);
  }
  
  if(ah > 70){
    fan_pump = true;
    digitalWrite(relay_3, HIGH);
    digitalWrite(relay_4, HIGH);
  }else{
    fan_pump = false;
    digitalWrite(relay_3, LOW);
    digitalWrite(relay_4, LOW);
  }
  
  if(temp > 40){
    digitalWrite(relay_3, HIGH);
  }else if(!fan_pump){
    digitalWrite(relay_3, LOW);
  }
  
  send_log(lux, temp, soil, ah);
}

void print_lcd(int lux, float temp, int h, int ah){
  lcd.setCursor(12, 0);
  for(int i=0;i<6;i++){
    lcd.print(" ");
  }
  lcd.setCursor(12, 0);
  lcd.print(h);
  lcd.setCursor(12, 1);
  for(int i=0;i<6;i++){
    lcd.print(" ");
  }
  lcd.setCursor(12, 1);
  lcd.print(lux);
  lcd.setCursor(12, 2);
  for(int i=0;i<6;i++){
    lcd.print(" ");
  }
  lcd.setCursor(12, 2);
  lcd.print(ah);
  lcd.setCursor(12, 3);
  for(int i=0;i<6;i++){
    lcd.print(" ");
  }
  lcd.setCursor(12, 3);
  lcd.print(temp);
}

String get_value(const char url[]){
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

void send_log(int var1, float var2, int var3, int var4){
  String data ="";
  EthernetClient client;
  String s_var1 = "var1=";
  String s_var2= "&var2=";
  String s_var3= "&var3=";
  String s_var4= "&var4=";
  data = s_var1+var1+s_var2+var2+s_var3+var3+s_var4+var4;
  Serial.println(data);

  if (client.connect(server,80))
  {
    client.print("POST /api/gcs/gcs_insert_log HTTP/1.1\n");
    client.print("Host: 192.168.2.4\n");
    client.print("Connection: close\n");
    client.print("Content-Type: application/x-www-form-urlencoded\n");
    client.print("Content-Length: ");
    client.print(data.length());
    client.print("\n\n");
    client.print(data);
  }else{
    Serial.println("Sending failed");
  }
}

int BH1750_Read(int address){
  int i=0;
  Wire.beginTransmission(address);
  Wire.requestFrom(address, 2);
  while(Wire.available()){
    buff[i] = Wire.read();
    i++;
  }
  Wire.endTransmission();  
  return i;
}
 
void BH1750_Init(int address){
  Wire.beginTransmission(address);
  Wire.write(0x10);
  Wire.endTransmission();
}


