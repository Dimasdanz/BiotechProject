#include <OneWire.h>
#include <DallasTemperature.h>
#include <SPI.h>
#include <HttpClient.h>
#include <Ethernet.h>
#include <EthernetClient.h>

const int smoke_pin = A0;
const int temp_pin =  2;

byte mac[] = {0x90, 0xA2, 0xDA, 0x0E, 0xF5, 0x30 };
const char server[] = "192.168.1.3";
IPAddress ip(192,168,4,3);

OneWire oneWire(temp_pin);
DallasTemperature temp_sensor(&oneWire);

void setup() {
  Serial.begin(9600);
  pinMode(smoke_pin, INPUT);
  temp_sensor.begin();
  Ethernet.begin(mac, ip);
  delay(1000);
}

void loop() {
  temp_sensor.requestTemperatures();
  Serial.println(analogRead(smoke_pin));  
  Serial.println(temp_sensor.getTempCByIndex(0));
  send_log(temp_sensor.getTempCByIndex(0), analogRead(smoke_pin));
  delay(5000);
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
