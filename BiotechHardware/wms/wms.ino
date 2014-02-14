#include <SPI.h>
#include <HttpClient.h>
#include <Ethernet.h>
#include <EthernetClient.h>

byte mac[] = {0x90, 0xA2, 0xDA, 0x0E, 0xF5, 0x30 };
const char server[] = "192.168.1.3";
const char log_path[] = "/api/wms_insert_log";
IPAddress ip(192,168,4,3);

const int pingPin = 2;

int BH1750address = 0x23;
byte buff[2];
uint16_t val = 0;

void setup() {
  Serial.begin(9600);
  Ethernet.begin(mac, ip);
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
  
  cm = (duration/58); //Water Level
  
  Serial.print(cm);
  Serial.print("cm");
  Serial.println();
  
  BH1750_Init(BH1750address);
  delay(200);
  
  if(2==BH1750_Read(BH1750address)) {
    val=((buff[0]<<8)|buff[1])/1.2;
    Serial.print(val);
    Serial.println("[lx]"); //Lux Meter
  }
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

