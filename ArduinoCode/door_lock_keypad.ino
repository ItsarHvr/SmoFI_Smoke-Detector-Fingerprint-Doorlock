#include <Keypad.h>
#include<EEPROM.h>

#define relay 12

char password[4];
char pass[4],pass1[4];
int i=0;
char customKey=0;

const byte ROWS = 4; //four rows
const byte COLS = 4; //four columns

char hexaKeys[ROWS][COLS] = {
  {'1','2','3','A'},
  {'4','5','6','B'},
  {'7','8','9','C'},
  {'*','0','#','D'}
};

byte rowPins[ROWS] = {9, 8, 7, 6}; //connect to the row pinouts of the keypad
byte colPins[COLS] = {5, 4, 3, 2}; //connect to the column pinouts of the keypad

//initialize an instance of class NewKeypad
Keypad customKeypad = Keypad( makeKeymap(hexaKeys), rowPins, colPins, ROWS, COLS); 

void setup()
{
  Serial.begin(9600);
  pinMode(led, OUTPUT);
  pinMode(buzzer, OUTPUT);
  pinMode(relay, OUTPUT);
  Serial.println("Masukan Passsword:");
  for(int j=0;j<4;j++)
  EEPROM.write(j, j+49);
  for(int j=0;j<4;j++)
  pass[j]=EEPROM.read(j);
}
  
void loop()
{
  customKey = customKeypad.getKey();
  if(customKey=='#')
  change();
  if (customKey)
  {
     password[i++]=customKey;
     Serial.print(customKey);
  }
  if(i==4)
  {
    delay(200);
    for(int j=0;j<4;j++)
    pass[j]=EEPROM.read(j);
    if(!(strncmp(password, pass,4)))
    {
      digitalWrite(led, HIGH);
      digitalWrite(relay, HIGH);
      beep();
      Serial.println("Password Diterima");
      delay(2000);
      Serial.println(" Tekan # Ganti Password");
      delay(3000);
      Serial.println("Masukan Password: ");
      i=0;
      digitalWrite(led, LOW);
      digitalWrite(relay, LOW);
    }
    
    else
    {
      digitalWrite(buzzer, HIGH);
      Serial.println("Anda Tidak Memiliki Akses");
      Serial.println("Tekan # Ganti Password");
      delay(2000);
      Serial.println("Masukan Password: ");
      i=0;
      digitalWrite(buzzer, LOW);
    }
  }
}

void change()
{
  int j=0;
  Serial.println("Masukan Password Sebelumnya ");
  while(j<4)
  {
    char key=customKeypad.getKey();
    if(key)
    {
      pass1[j++]=key;
      Serial.print(key);
    }
    key=0;
  }
  delay(500);
  
  if((strncmp(pass1, pass, 4)))
  {
    Serial.println("Password Salah...");
    Serial.println("Silahkan Coba Lagi");
    delay(1000);
  }
  else
  {
    j=0;
    
  Serial.println("Masukan Password Baru:");
  while(j<4)
  {
    char key=customKeypad.getKey();
    if(key)
    {
      pass[j]=key;
      Serial.print(key);
      EEPROM.write(j,key);
      j++;
    }
  }
  Serial.println("Berhasil ");
  delay(1000);
  }
  Serial.println("Masukan Password :");
  customKey=0;
}
