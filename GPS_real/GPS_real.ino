#include <TinyGPS.h>
#include "TPB23.h"
#define DebugSerial Serial
#define NBSerial Serial1

String num = "1 ";    // 버스 넘버 보드마다 바꾸기 

TPB23 TPB23(NBSerial, DebugSerial);
TinyGPS gps;
int UDP_flag = 0;
String final_position = "test";
float debug_flat = 0;
float debug_flon = 0;

String flat_zip(String flat)
{
  String fin_flat = "0123";
  fin_flat[0] = ((flat[1]&0x0f)<<4)|(flat[2]&0x0f);
  fin_flat[1] = ((flat[4]&0x0f)<<4)|(flat[5]&0x0f);
  fin_flat[2] = ((flat[6]&0x0f)<<4)|(flat[7]&0x0f);
  fin_flat[3] = ((flat[8]&0x0f)<<4)|(flat[9]&0x0f);
  return fin_flat;
}

String flon_zip(String flon)
{
  String fin_flon = "0123";
  fin_flon[0] = ((flon[0]&0x0f)<<4)|(flon[1]&0x0f);
  fin_flon[1] = ((flon[3]&0x0f)<<4)|(flon[4]&0x0f);
  fin_flon[2] = ((flon[5]&0x0f)<<4)|(flon[6]&0x0f);
  fin_flon[3] = ((flon[7]&0x0f)<<4)|(flon[8]&0x0f);
  return fin_flon;
}

int time_bool()
{
  int year;
  byte month, day, hour, minute, second, hundredths;
  unsigned long age;
  
  gps.crack_datetime(&year, &month, &day, &hour, &minute, &second, &hundredths, &age);

  if( (hour <= 14) && (hour >=23) ) return 1;
  else return 0;
}

void sendvalue(){
    //UDP Socket Text Echo Test 
  char _IP[] = "119.67.32.123"; //Server IP
  int  _PORT = 5959;            //Server Port

  char sendBuffer[] = "Hanium Project";
  final_position.toCharArray(sendBuffer,final_position.length());
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

void getgps(){
  float flat =0;
  float flon =0;
  unsigned long age;
  UDP_flag=0;

 for (unsigned long start = millis(); millis() - start < 1000;)
  {
    while (Serial2.available())
    {
      gps.encode(Serial2.read()); // Did a new valid sentence come in?
    }
  }

  if ( time_bool() )
  {
    return;
  }
  
    gps.f_get_position(&flat, &flon, &age);     // get gps data
    
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

        t_la = flat_zip(t_la);
        t_lo = flon_zip(t_lo);

        UDP_flag=1;
        final_position = (t_la+t_lo+num);
      }
 }

void setup() {
  Serial2.begin(9600);
  NBSerial.begin(9600);
  DebugSerial.begin(9600);
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
  getgps();
  if(UDP_flag==1)
  {
    sendvalue();
  }
