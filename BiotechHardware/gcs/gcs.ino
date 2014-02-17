#include <SPI.h>
#include <HttpClient.h>
#include <Ethernet.h>
#include <EthernetClient.h>

byte mac[] = { 0x90, 0xA2, 0xDA, 0x0E, 0xF5, 0x30 };

const char hostname[] = "192.168.1.3";
const char h_upper_url[] = "/api/gcs_";
const char h_lower_url[] = "/api/gcs_";
const char l_target_url[] = "/api/gcs_";

IPAddress ip(192,168,4,3);

const int h_pin = 2;
const int t_pin = 3;
const int ah_pin = 2;

void setup() {
  Serial.begin(9600);
  Ethernet.begin(mac, ip);
  delay(1000);
}

void loop()
{
  int h_upper = get_value(h_upper_url).toInt();
  int h_lower = get_value(h_lower_url).toInt();
  int l_target = get_value(l_target_url).toInt();
  if(analogRead(A0) > h_upper){
	//Do Something
  }else if(analogRead(A0) < h_lower){
	//Do Something
  }
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