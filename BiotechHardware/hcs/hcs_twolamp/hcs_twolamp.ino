#include <SPI.h>
#include <Ethernet.h>
#include <EthernetClient.h>
#include <HttpClient.h>

byte mac[] = { 0x90, 0xA2, 0xDA, 0x0E, 0xF5, 0x30 };
const char hostname[] = "192.168.1.4";
IPAddress ip(192,168,1,6);

int commaPosition;
String lamp1_val;
String lamp2_val;
String lamp3_val;
String lamp4_val;

const int lamp1_pin = 2;
const int lamp2_pin = 3;
const int lamp3_pin = 5;
const int lamp4_pin = 6;

void setup(){
  Serial.begin(9600);
  Serial.println("Start");
  Ethernet.begin(mac, ip);
  
  Serial.println(Ethernet.localIP());
  
  pinMode(lamp1_pin, OUTPUT);
  pinMode(lamp2_pin, OUTPUT);
  pinMode(lamp3_pin, OUTPUT);
  pinMode(lamp4_pin, OUTPUT);
  digitalWrite(lamp1_pin, HIGH);
  digitalWrite(lamp2_pin, HIGH);
  digitalWrite(lamp3_pin, HIGH);
  digitalWrite(lamp4_pin, HIGH);
  delay(1000);
}

void loop(){
  String val = get_lamp("/api/hcs/hcs_get_lamp");
  Serial.println(val);
  
  commaPosition = val.indexOf(';');
  lamp1_val = val.substring(1,commaPosition);
  val = val.substring(commaPosition+1, val.length());
  Serial.println(lamp1_val);
  
  commaPosition = val.indexOf(';');
  lamp2_val = val.substring(0,commaPosition);
  val = val.substring(commaPosition+1, val.length());
  Serial.println(lamp2_val);
  
  if(lamp1_val == "1"){
    digitalWrite(lamp1_pin, LOW);
    Serial.println("Lampu 1 Hidup");
  }else{
    digitalWrite(lamp1_pin, HIGH);
    Serial.println("Lampu 1 Mati");
  }
  
  if(lamp2_val == "1"){
    digitalWrite(lamp2_pin, LOW);
    Serial.println("Lampu 2 Hidup");
  }else{
    digitalWrite(lamp2_pin, HIGH);
    Serial.println("Lampu 2 Mati");
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


