#include <Adafruit_Fingerprint.h>
#include <SoftwareSerial.h>
#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27, 16,2);  // Set the LCD I2C address

SoftwareSerial mySerial(2, 3);

Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);

uint8_t id;

void setup()
{
  lcd.begin();
  Serial.begin(9600);
  while (!Serial);  // For Yun/Leo/Micro/Zero/...
  delay(100);

  // set the data rate for the sensor serial port
  finger.begin(57600);

  if (finger.verifyPassword()) {
    lcd.setCursor(2, 0);
    lcd.print("Fingerprint");
    lcd.setCursor(2, 1);
    lcd.print("Terdeteksi");
    Serial.println("Fingerprint Terdeteksi");
  } else {
    lcd.clear();
    lcd.setCursor(2, 0);
    lcd.print("Fingerprint");
    lcd.setCursor(0, 1);
    lcd.print("Tidak Terdeteksi");
    Serial.println("Fingerprint Tidak Terdeteksi");
    while (1) {
      delay(1);
    }
  }
}

uint8_t readnumber(void) {
  uint8_t num = 0;

  while (num == 0) {
    while (! Serial.available());
    num = Serial.parseInt();
  }
  return num;
}

void loop()
{
  Serial.println("Mendaftarkan Sidik Jari Anda");
  Serial.println("Masukkan ID dari 1-127");
  lcd.clear();
  lcd.setCursor(3, 0);
  lcd.print("Masukkan ID");
  lcd.setCursor(3, 1);
  lcd.print("Dari 1-127");
  id = readnumber();
  if (id == 0) {// ID #0 not allowed, try again!
    return;
  }
  Serial.print("Mendaftarkan ID #");
  Serial.println(id);
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Mendaftarkan ID ");
  lcd.print(id);

  while (!  getFingerprintEnroll() );
}

uint8_t getFingerprintEnroll() {

  int p = -1;
  Serial.print("Tempelkan Sidik Jari #"); Serial.println(id);
  lcd.clear();
  lcd.setCursor(3, 0);
  lcd.print("Tempelkan");
  lcd.setCursor(2, 1);
  lcd.print("Sidik Jari");
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Berhasil Direkam");
        break;
      case FINGERPRINT_NOFINGER:
        Serial.println(".");
        break;
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        break;
      case FINGERPRINT_IMAGEFAIL:
        Serial.println("Imaging error");
        break;
      default:
        Serial.println("Unknown error");
        break;
    }
  }

  // OK success!

  p = finger.image2Tz(1);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  Serial.println("Angkat");
  lcd.clear();
  lcd.setCursor(4, 0);
  lcd.print("Angkat");
  delay(2000);
  p = 0;
  while (p != FINGERPRINT_NOFINGER) {
    p = finger.getImage();
  }
  Serial.print("ID "); Serial.println(id);
  p = -1;
  Serial.println("Tempelkan Lagi");
  lcd.clear();
  lcd.setCursor(2, 0);
  lcd.print("Tempelkan Lagi");
  while (p != FINGERPRINT_OK) {
    p = finger.getImage();
    switch (p) {
      case FINGERPRINT_OK:
        Serial.println("Image taken");
        break;
      case FINGERPRINT_NOFINGER:
        Serial.print(".");
        break;
      case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");
        break;
      case FINGERPRINT_IMAGEFAIL:
        Serial.println("Imaging error");
        break;
      default:
        Serial.println("Unknown error");
        break;
    }
  }

  // OK success!

  p = finger.image2Tz(2);
  switch (p) {
    case FINGERPRINT_OK:
      Serial.println("Image converted");
      break;
    case FINGERPRINT_IMAGEMESS:
      Serial.println("Image too messy");
      return p;
    case FINGERPRINT_PACKETRECIEVEERR:
      Serial.println("Communication error");
      return p;
    case FINGERPRINT_FEATUREFAIL:
      Serial.println("Could not find fingerprint features");
      return p;
    case FINGERPRINT_INVALIDIMAGE:
      Serial.println("Could not find fingerprint features");
      return p;
    default:
      Serial.println("Unknown error");
      return p;
  }

  // OK converted!
  Serial.print("Mendaftarkan Sidik Jari #");  Serial.println(id);
  lcd.clear();
  lcd.setCursor(3, 0);
  lcd.print("Mendaftar");
  delay(1000);

  p = finger.createModel();
  if (p == FINGERPRINT_OK) {
    Serial.println("Sidik Jari Cocok!");
    lcd.clear();
    lcd.setCursor(2, 0);
    lcd.print("Sidik Jari");
    lcd.setCursor(4, 1);
    lcd.print("Cocok");
    delay(1000);
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_ENROLLMISMATCH) {
    Serial.println("Fingerprints did not match");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }

  Serial.print("ID "); Serial.println(id);
  p = finger.storeModel(id);
  if (p == FINGERPRINT_OK) {
    Serial.println("Sidik Jari Disimpan!");
    lcd.clear();
    lcd.setCursor(2, 0);
    lcd.print("Data Disimpan");
    delay(2000);
  } else if (p == FINGERPRINT_PACKETRECIEVEERR) {
    Serial.println("Communication error");
    return p;
  } else if (p == FINGERPRINT_BADLOCATION) {
    Serial.println("Could not store in that location");
    return p;
  } else if (p == FINGERPRINT_FLASHERR) {
    Serial.println("Error writing to flash");
    return p;
  } else {
    Serial.println("Unknown error");
    return p;
  }
}
