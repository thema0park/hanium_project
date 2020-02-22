#include <TinyGPS++.h>
#include "TPB23.h"
#define DebugSerial Serial
#define NBSerial Serial1

#include "DHT.h"
#define DHTPIN 49
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);
#define LED 13
#define HALL_1 53
#define HALL_2 51
#define COOL 47

// 빨강 vcc 검정 gnd 노랑 rx 초록 tx

String equip_num_zip()
{
  String equip = "91";                        // 장비 번호
  String num = "0";
  num[0] = ((equip[0]&0x0f)<<4)|(equip[1]&0x0f);
  Serial.println(num);
  return num;
}

String env_info_zip(String env_info)
{
  String zip_env = "0123";
  zip_env[0] = ((env_info[0]&0x0f)<<4)|(env_info[1]&0x0f);
  zip_env[1] = ((env_info[3]&0x0f)<<4)|(env_info[4]&0x0f);
  zip_env[2] = ((env_info[5]&0x0f)<<4)|(env_info[6]&0x0f);
  zip_env[3] = ((env_info[7]&0x0f)<<4)|(env_info[8]&0x0f);
  /*
  Serial.print("env_info[0] : ");
  Serial.println(env_info[0]);
  Serial.print("env_info[1] : ");
  Serial.println(env_info[1]);
  Serial.print("env_info[2] : ");
  Serial.println(env_info[2]);
  Serial.print("env_info[3] : ");
  Serial.println(env_info[3]);
  Serial.print("env_info[4] : ");
  Serial.println(env_info[4]);
  Serial.print("env_info[5] : ");
  Serial.println(env_info[5]);
  Serial.print("env_info[6] : ");
  Serial.println(env_info[6]);
  Serial.print("env_info[7] : ");
  Serial.println(env_info[7]);
  Serial.print("env_info[8] : ");
  Serial.println(env_info[8]);
  */
  return zip_env;
}

TPB23 TPB23(NBSerial, DebugSerial);
TinyGPSPlus gps;

int UDP_flag = 0;
String final_position = "test";
float debug_flat = 0;
float debug_flon = 0;

String flat_zip(String flat)
{
  String zip_flat = "0123";
  zip_flat[0] = ((flat[0]&0x0f)<<4)|(flat[1]&0x0f);
  zip_flat[1] = ((flat[3]&0x0f)<<4)|(flat[4]&0x0f);
  zip_flat[2] = ((flat[5]&0x0f)<<4)|(flat[6]&0x0f);
  zip_flat[3] = ((flat[7]&0x0f)<<4)|(flat[8]&0x0f);
  return zip_flat;
}

String flon_zip(String flon)
{
  String zip_flon = "0123";
  zip_flon[0] = ((flon[1]&0x0f)<<4)|(flon[2]&0x0f);
  zip_flon[1] = ((flon[4]&0x0f)<<4)|(flon[5]&0x0f);
  zip_flon[2] = ((flon[6]&0x0f)<<4)|(flon[7]&0x0f);
  zip_flon[3] = ((flon[8]&0x0f)<<4)|(flon[9]&0x0f);
  return zip_flon;
}

void sendvalue(){
    //UDP Socket Text Echo Test 
  char _IP[] = "119.67.32.123"; //Server IP
  int  _PORT = 5959;            //Server Port

  char sendBuffer[] = "Hanium Project111111111";
  final_position.toCharArray(sendBuffer,final_position.length()+1);
  Serial.println(sendBuffer);
  
  //Socket Create
  // A number in the range 0-65535 except 5683 
  if(TPB23.socketCreate(0) == 0)
    DebugSerial.println("Socket Create!!!");
  
  // Socket Send 
    if(TPB23.socketSend(_IP, _PORT, sendBuffer) == 0){
      DebugSerial.print("[UDP Send] >>  ");
      DebugSerial.println(sendBuffer);
    }
    else
      DebugSerial.println("Send Fail!!!");
  
  // Socket Close 
    if(TPB23.socketClose() == 0)
      DebugSerial.println("Socket Close!!!");
    delay(10000);
}

void getinfo(){
  float flat =0;
  float flon =0;

  int HALL_L =digitalRead(HALL_1);
  int HALL_R =digitalRead(HALL_2);

  float h = dht.readHumidity();// 습도를 측정합니다.
  float t = dht.readTemperature();// 온도를 측정합니다.

  if (isnan(h) || isnan(t) ){
    Serial.println("Failed to read from DHT sensor!");
  }
  
  UDP_flag=0;



 for (unsigned long start = millis(); millis() - start < 1000;)
  {
    while (Serial2.available())
    {
      gps.encode(Serial2.read()); // Did a new valid sentence come in?
    }
  }
    flat = gps.location.lat();
    flon = gps.location.lng();
    
      if((flat==0 && flon==0) || (flat==1000 && flon==1000))
      {
        Serial.println("gps not start..");
      }
      else if ( flat == debug_flat && flon == debug_flon ) 
      {
        Serial.println("same gps data..");
      }
      else
      {
        debug_flat = flat;
        debug_flon = flon;
        
        String t_la = String(flat,6);
        String t_lo = String(flon,6);
        String equip_num = "0";
        String env_info ="0000";
        String H;
        if (HALL_L >0 && HALL_R>0)
        {
          H = "1";
        }
        else
        {
            H="0";
        }
        String temp = String(t);
        String humi= String(int(h));
        if(temp.length()<5)
        {
          temp = "0" + String(t);  
        }

        if(humi.length()<2)
        {
          humi = "0" + String(int(h));
        }
        String cooling;
        if(t>20)
        {
          cooling = "1";
          digitalWrite(COOL,1);
        }
        else
        {
          cooling ="0";
          digitalWrite(COOL,0);
        }

        t_la = flat_zip(t_la);
        t_lo = flon_zip(t_lo);
        equip_num = equip_num_zip();
        //Serial.print((temp+humi+H+cooling).length());
        env_info =env_info_zip(temp+humi+H+cooling);
        Serial.print("env_info : ");
        Serial.println(env_info);

        UDP_flag=1;
        final_position = (t_lo+t_la+equip_num+env_info);
      }
 }

void setup() {
  Serial2.begin(9600);
  NBSerial.begin(9600);
  DebugSerial.begin(9600);

  pinMode(HALL_1, INPUT);
  pinMode(HALL_2, INPUT);
  pinMode(COOL, OUTPUT);

  dht.begin();
  
  if(TPB23.init()){
    DebugSerial.println("TPB23 Module Error!!!");
  }
  while(TPB23.canConnect() != 0){
    DebugSerial.println("Network not Ready !!!");
    delay(2000);
  }
  if(TPB23.reportDevice() == 0)
  {
    DebugSerial.println("TPB23 Device Report Success!!!");
  }    
  delay(2000);
  DebugSerial.println("TPB23 Module Ready!!!"); 
}

void loop() {
  getinfo();
  if(UDP_flag==1) sendvalue();
  delay(10000);
}
