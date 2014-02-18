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
const char hostname[] = "192.168.1.3";
IPAddress ip(192,168,4,3);

LiquidCrystal_I2C lcd(0x27,20,4);

const int h_pin = A0;
const int t_pin = 3;
const int ah_pin = 2;
int commaPosition;

OneWire oneWire(t_pin);
DallasTemperature temp_sensor(&oneWire);
dht11 DHT11;

int h_low;
int h_upper;
int l_target;

BH1750 lightMeter;

void setup(){
  Serial.begin(9600);
  lightMeter.begin();
  Ethernet.begin(mac, ip);
  delay(1000);
}

void loop(){
  String val = get_value("/api/gcs_get_value");
  
  commaPosition = val.indexOf(';');
  h_low = val.substring(0,commaPosition).toInt();
  val = val.substring(commaPosition+1, val.length());
  Serial.println(h_low);
  
  commaPosition = val.indexOf(';');
  h_upper = val.substring(0,commaPosition).toInt();
  Serial.println(h_upper);
  
  l_target = val.substring(commaPosition+1, val.length()).toInt();
  Serial.println(l_target);
  
  int lux = lightMeter.readLightLevel();
  Serial.print("Light: ");
  Serial.print(lux);
  Serial.println(" lx");
  
  temp_sensor.requestTemperatures();
  float temp = temp_sensor.getTempCByIndex(0);
  Serial.println(temp);
  
  int humidity = analogRead(h_pin);
  Serial.println(humidity);
  
  DHT11.read(ah_pin);
  float ah = DHT11.humidity;
  Serial.println(ah);
}

String get_value(const char url[]){
  int err = 0;
  int stringPos = 0; 
  char inString[32];
  memset( &inString, 0, 32 );
  EthernetClient c;
  HttpClient http(c);
  err = http.get(hostname, url);
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


