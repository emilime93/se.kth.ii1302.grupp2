/*
@Author: Elias Chahine
@Date: 2018-05-04
@Note: This file contains methods for wifi module for initialization.
*/


#include "usart.h"
#include "initWifi.h"
#include "math.h"
#include "stdio.h"
#include "string.h"

#define BufferSize 100
static char commandSocket[3][20];
static uint8_t readUartBuffer[BufferSize];

void clearBufferIT(){
  for(int i = 0; i < BufferSize; i++){
    readUartBuffer[i] = '\0';
  }
}

void recWifi(){
  for(int i = 0; i < BufferSize; i++){
    if(HAL_UART_Receive_IT(&huart1, (uint8_t *)&readUartBuffer, 1)!=HAL_OK){
      printf("\r\nerror receive\r\n");
    }
    while(huart1.RxState != HAL_UART_STATE_READY);
    if(readUartBuffer[i] == '\n'){
      break;
    }
  }
}


void readFromSocket(){
  sprintf(commandSocket[0], "AT+S.SOCKDR=0,0,0\r\n");
  clearBufferIT();
  uint8_t i = 0;
  while(i == 0){
    recWifi();
    if(strcmp(readUartBuffer, "+WIND:61:Incoming Socket Client:1")==0){
      i = 1;
    }else{clearBufferIT();}
  }
  transmitWifi(commandSocket[0]);
  
}


void checkDHCP(){
  uint8_t i = 0;
  while(i == 0){
    recWifi();
    HAL_Delay(20);
    if(strcmp(readUartBuffer,"+WIND:29:DHCP Reply:192.168.0.2\r\n") == 0){
      printf("true\r\n");
      i = 1;
    }
    else{clearBufferIT();}
  }
}

void readData(){
  uint8_t i = 0;
  clearBufferIT();
  static uint8_t data [8];
  while(i == 0){
    recWifi();
    for(int i = 0; i < sizeof(readUartBuffer); i++){
      data[i] = readUartBuffer[i];
    } 
    if(data[i] == '5'){
      if(data[6]== '5'){
        if(strcmp(data,"+WIND:55")==0){
          printf("\r\ndata is there");
          i = 1;
        }else{
          for(int i = 0; i < sizeof(data); i++){
            data[i] = '\0';
          }
          clearBufferIT();
        }
      }
    }else{
      for(int i = 0; i < sizeof(data); i++){
        data[i] = '\0';
      }
      clearBufferIT();
    }
  } 
}