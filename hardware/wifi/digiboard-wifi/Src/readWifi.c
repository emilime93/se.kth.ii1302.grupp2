/*
@Author: Elias Chahine
@Date: 2018-05-04
@Note: This file contains methods for wifi module for initialization.
*/


#include "usart.h"
#include "initWifi.h"
static char commandSocket[3][20];
void readFromSocket(){
  sprintf(commandSocket[0], "AT+S.SOCKDR=0,0,0\r\n");
  transmitWifi(commandSocket[0]);
  receiveWifi();
  printf("wow");
  char receiverBuffer = sendReceiverBuffer();
  printf("%d",receiverBuffer);
}
void waitSocketClient(){
  receiveWifi();
  char checkBuffer = sendReceiverBuffer();
  for(int i = 0; i < strlen(checkBuffer); i++){
    if(strcmp(checkBuffer,"+WIND:61:Incoming Socket Client:192.168.0.2:64168:0:0\r\n")){
      printf(&checkBuffer);
    }else{
      clearBuffer();
    }
  }
}
