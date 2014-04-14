void setup(){
	Serial.begin(9600);
	attachInterrupt(0, testing, CHANGE);
}

void loop(){
	for (int i = 0; i < 100; i++){
		delay(10);
	}
}

void testing(){
	Serial.println("Test");
}