#include <Adafruit_Fingerprint.h>
#include <SoftwareSerial.h>
#include <SPI.h>
#include <Ethernet.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27, 16, 2); // Set the LCD I2C address

//Connection via LAN
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
char server[] = "192.168.0.1";
IPAddress ip(192, 168, 0, 10);// give your Ip in the same Class
EthernetClient client;

int getFingerprintIDez();
// pin #2 is IN from sensor (GREEN wire)
// pin #3 is OUT from arduino (WHITE wire)
SoftwareSerial mySerial(2, 3);
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);
// On Leonardo/Micro or others with hardware serial, use those! #0 is green wire, #1 is white
//Adafruit_Fingerprint finger = Adafruit_Fingerprint(&Serial1);

int lockdoor = 4;
int buzzer = 5;

void setup() {
  while (!Serial); // For Yun/Leo/Micro/Zero/...
  lcd.begin();
  Serial.begin(9600);
  pinMode(lockdoor, OUTPUT);
  pinMode(buzzer, OUTPUT);
  // start the Ethernet connection:
  // try to congifure using IP address instead of DHCP:
  Ethernet.begin(mac, ip);
  // give the Ethernet shield a second to initialize:
  delay(1000);
  Serial.print("Alamat IP : ");
  Serial.println(Ethernet.localIP());
  lcd.setCursor(0, 0);
  lcd.print("IP: ");
  lcd.print(Ethernet.localIP());
  finger.begin(57600);
  if (client.connect(server, 80)) {
  if (finger.verifyPassword()) {
    lcd.setCursor(2, 0);
    lcd.print("Fingerprint");
    lcd.setCursor(1, 1);
    lcd.print("Terdeteksi");
    Serial.println("Fingerprint Terdeteksi");
  } else {
    lcd.clear();
    lcd.setCursor(2, 0);
    lcd.print("Fingerprint");
    lcd.setCursor(0, 1);
    lcd.print("Tidak Terdeteksi");
    Serial.println("Fingerprint Tidak Terdeteksi");
    while (1);
  }
 }else{
 serverdisable();
  }
  tempel();
}
void loop() // run over and over again
{
  getFingerprintIDez();
  delay(50); //don't ned to run this at full speed.
}

// returns -1 if failed, otherwise returns ID #
int getFingerprintIDez() {
  uint8_t p = finger.getImage();
  if (p != FINGERPRINT_OK) return -1;
  p = finger.image2Tz();
  if (p != FINGERPRINT_OK) return -1;
  p = finger.fingerFastSearch();
  if (!client.connect(server, 80)) {
    serverdisable();
    }
  if (p == FINGERPRINT_OK) { //jika fingerprint terdeteksi
    Serial.println("Sidik Jari Cocok");
    Serial.print("ID #"); Serial.println(finger.fingerID);
    Serial.print("Dengan kecocokan : "); Serial.println(finger.confidence);
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Sidik Jari Cocok");
    digitalWrite(lockdoor, HIGH);
    client.stop();
    if (client.connect(server, 80)) {
      //Serial.println("Terkoneksi ke Server");
      // Make a HTTP request:
      client.println("GET /finger/get-id.php?id=" + (String)finger.fingerID);
      client.println("Host: 192.168.0.1");
      client.println("Connection: close");
      client.println();
      lcd.clear();
      lcd.setCursor(1, 0);
      lcd.print("Pintu Terbuka");
      delay(5000);
      lcd.clear();
      lcd.setCursor(1, 0);
      lcd.print("Data Terkirim");
      lcd.setCursor(3, 1);
      lcd.print("Ke Server");
      Serial.println("Data Terkirim ke Server");
    } else {
      lcd.clear();
      lcd.setCursor(1, 0);
      lcd.print("Pintu Terbuka");
      delay(2000);
      lcd.clear();
      lcd.setCursor(1, 0);
      lcd.print("Gagal Dikirim");
      lcd.setCursor(3, 1);
      lcd.print("Ke Server");
      Serial.println("Data Tidak Terkirim ke Server");
    }
    delay(2000);
    digitalWrite(lockdoor, LOW);
    tempel();
    return finger.fingerID;
  }
  else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  }
  else if (p == FINGERPRINT_NOTFOUND) { //jika fingerprint salah
    Serial.println("Sidik Jari Tidak Terdaftar");
    lcd.clear();
    lcd.setCursor(3, 0);
    lcd.print("Sidik Jari");
    lcd.setCursor(1, 1);
    lcd.print("Tidak Terdaftar");
    digitalWrite(buzzer, HIGH);
    delay(500);
    digitalWrite(buzzer, LOW);
    delay(500);
    digitalWrite(buzzer, HIGH);
    delay(500);
    digitalWrite(buzzer, LOW);
    delay(500);
    digitalWrite(buzzer, HIGH);
    delay(500);
    digitalWrite(buzzer, LOW);
    delay (2000);
    tempel();
  }
  else {
    Serial.println("Unknown error");
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("??");
    delay (100);
    return p;
  }
}

void tempel() {
  if (client.connect(server, 80)) {
  lcd.clear();
  lcd.setCursor(1, 0);
  lcd.print("Tempelkan Sidik");
  lcd.setCursor(3, 1);
  lcd.print("Jari Anda");
  Serial.println("Tempelkan Sidik Jari Anda");
  }else{
  serverdisable();
    }
}

void serverdisable(){
  lcd.clear();
  lcd.setCursor(5, 0);
  lcd.print("Server");
  lcd.setCursor(4, 1);
  lcd.print("Terputus");
  Serial.println("Server Terputus");
  while (1);
  }
