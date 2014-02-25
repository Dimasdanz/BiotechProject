#include <SPI.h>
#include <HttpClient.h>
#include <Ethernet.h>
#include <EthernetClient.h>

byte mac[] = { 0x90, 0xA2, 0xDA, 0x0E, 0xF5, 0x30 };

const char hostname[] = "192.168.1.3";
const char lamp1_path[] = "/api/hcs_lamp_value/lamp_1";
const char lamp2_path[] = "/api/hcs_lamp_value/lamp_2";
const char lamp3_path[] = "/api/hcs_lamp_value/lamp_3";
const char lamp4_path[] = "/api/hcs_lamp_value/lamp_4";

IPAddress ip(192,168,4,3);

const int lamp1_pin = 2;
const int lamp2_pin = 3;
const int lamp3_pin = 4;
const int lamp4_pin = 5;

void setup() {
  Ethernet.begin(mac, ip);
  pinMode(lamp1_pin, OUTPUT);
  pinMode(lamp2_pin, OUTPUT);
  pinMode(lamp3_pin, OUTPUT);
  pinMode(lamp4_pin, OUTPUT);
  delay(1000);
}

void loop()
{
  if(get_lamp(lamp1_path).toInt() == 1){
    digitalWrite(lamp1_pin, HIGH);
  }else{
    digitalWrite(lamp1_pin, LOW);
  }
  
  if(get_lamp(lamp2_path).toInt() == 1){
    digitalWrite(lamp2_pin, HIGH);
  }else{
    digitalWrite(lamp2_pin, LOW);
  }
  
  if(get_lamp(lamp3_path).toInt() == 1){
    digitalWrite(lamp3_pin, HIGH);
  }else{
    digitalWrite(lamp3_pin, LOW);
  }
  
  if(get_lamp(lamp4_path).toInt() == 1){
    digitalWrite(lamp4_pin, HIGH);
  }else{
    digitalWrite(lamp4_pin, LOW);
  }
}

String get_lamp(const char lamp[]){
  int err = 0;
  int stringPos = 0; 
  char inString[32];
  memset( &inString, 0, 32 );
  EthernetClient c;
  HttpClient http(c);
  err = http.get(hostname, lamp);
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


