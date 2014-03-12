#include <SPI.h>
#include <HttpClient.h>
#include <Ethernet.h>
#include <Wire.h>
#include <math.h>

byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
const char server[] = "192.168.1.3";
IPAddress ip(192,168,3,10);

const int pingPin = 5;
const int relay1 = 6;
const int relay2 = 7;

boolean kuras=false;

int BH1750address = 0x23;
byte buff[2];

void setup() {
  Wire.begin();
  Serial.begin(9600);
  Serial.println("Start");
  /*if(Ethernet.begin(mac) == 0){
    Serial.println("Failed to configure Ethernet using DHCP");
    Ethernet.begin(mac, ip);
  }*/
  Ethernet.begin(mac, ip);
  pinMode(relay1, OUTPUT);
  pinMode(relay2, OUTPUT);
  digitalWrite(relay1, HIGH);
  digitalWrite(relay2, HIGH);
  Serial.println(Ethernet.localIP());
  delay(1000);
}

void loop(){
  long duration, cm;
  pinMode(pingPin, OUTPUT);
  digitalWrite(pingPin, LOW);
  delayMicroseconds(2);
  digitalWrite(pingPin, HIGH);
  delayMicroseconds(5);
  digitalWrite(pingPin, LOW);

  pinMode(pingPin, INPUT);
  duration = pulseIn(pingPin, HIGH);

  cm = (duration/58);

  Serial.print(cm);
  Serial.print("cm");
  Serial.println();
  uint16_t lux=0;
  BH1750_Init(BH1750address);
  delay(200);

  if(2==BH1750_Read(BH1750address))
  {
    lux=((buff[0]<<8)|buff[1]);
    Serial.print("Light: ");
    Serial.print(lux);
    Serial.println(" lx");
    send_log(cm, lux);
  }
  String val = get_value("/api/wms_get_value");
  
  if(lux < 50){
    Serial.println("Kuras");
    digitalWrite(relay2, LOW);
    kuras = true;
  }
  
  if(kuras){
    if((val.toInt()-cm) < 5){
      Serial.println("Kosong abis kuras");
      digitalWrite(relay2, HIGH);
      digitalWrite(relay1, HIGH);
      kuras = false;
    }
  }else{
    if((val.toInt()-cm) < 50){
      Serial.println("Kosong");
      digitalWrite(relay1, LOW);
    }else if((val.toInt()-cm) > (val.toInt()-50)){
      Serial.println("Penuh");
      digitalWrite(relay1, HIGH);
    }
  }
  delay(1000);
}

void send_log(int var1, int var2){
  String data ="";
  EthernetClient client;
  String s_var1 = "var1=";
  String s_var2= "&var2=";
  data = s_var1+var1+s_var2+var2;
  Serial.println(data);

  if (client.connect(server,80))
  {
    client.print("POST /api/wms_insert_log HTTP/1.1\n");
    client.print("Host: 192.168.1.3\n");
    client.print("Connection: close\n");
    client.print("Content-Type: application/x-www-form-urlencoded\n");
    client.print("Content-Length: ");
    client.print(data.length());
    client.print("\n\n");
    client.print(data);
  }
  else
  {
    Serial.println("Fail");
  }
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

int BH1750_Read(int address)
{
  int i=0;
  Wire.beginTransmission(address);
  Wire.requestFrom(address, 2);
  while(Wire.available())
  {
    buff[i] = Wire.read();
    i++;
  }
  Wire.endTransmission();  
  return i;
}

void BH1750_Init(int address) 
{
  Wire.beginTransmission(address);
  Wire.write(0x10);
  Wire.endTransmission();
}

