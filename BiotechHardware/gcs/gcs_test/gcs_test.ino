#include <Wire.h>
#include <BH1750.h>
#include <LiquidCrystal_I2C.h>
#include <OneWire.h>
#include <DallasTemperature.h>
#include <dht11.h>

LiquidCrystal_I2C lcd(0x27,20,4);

const int h_pin = A3;
const int t_pin = 9;
const int ah_pin = 8;

const int relay_1 = 2;
const int relay_2 = 3;
const int relay_3 = 5;
const int relay_4 = 6;
int commaPosition;

OneWire oneWire(t_pin);
DallasTemperature temp_sensor(&oneWire);
dht11 DHT11;

int h_low;
int h_upper;
int l_target;

int BH1750address = 0x23;
byte buff[2];

void setup(){
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
  Serial.begin(9600);
  pinMode(relay_1, OUTPUT);
  pinMode(relay_2, OUTPUT);
  pinMode(relay_3, OUTPUT);
  pinMode(relay_4, OUTPUT);
  digitalWrite(relay_1, HIGH);
  digitalWrite(relay_2, HIGH);
  digitalWrite(relay_3, HIGH);
  digitalWrite(relay_4, HIGH);
}

void loop(){  
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
  Serial.print("Real Value: ");
  Serial.println(analogRead(h_pin));
  Serial.print("Soil: ");
  Serial.println(soil);
  
  DHT11.read(ah_pin);
  int ah = DHT11.humidity;
  
  Serial.println(ah);
  print_lcd(lux, temp, soil, ah);
  //send_log(lux, temp, h, ah);
  delay(1000);
  /*delay(10000);
  digitalWrite(relay_1, LOW);
  digitalWrite(relay_2, LOW);
  digitalWrite(relay_3, LOW);
  digitalWrite(relay_4, LOW);*/
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


