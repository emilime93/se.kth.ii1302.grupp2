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
#include "displayMethods.h"
#include "readWifi.h"

#define BufferSize 100
static char commandSocket[] = "AT+S.SOCKDR=0,0,0\r\n";
static uint8_t readUartBuffer[BufferSize];
static uint8_t testBuffer[BufferSize];
static uint8_t wind55[]="+WIND:55";
static uint8_t reading[]="AT-S.Reading";
static uint8_t svar [BufferSize];
static uint8_t trimmedSvar[BufferSize];


void recWifi(){
  readUartBuffer[0] = '\0';
  static uint8_t i = 0;
  for( i = 0; i < BufferSize; i++){
    
    if(HAL_UART_Receive_IT(&huart1, (uint8_t *)&readUartBuffer[i], 1)!=HAL_OK){
      printf("\r\nerror receive\r\n");
    }
    while(huart1.RxState != HAL_UART_STATE_READY);
    if(readUartBuffer[0] == '\0'){
      i = -1;
      continue;
    }
    if(readUartBuffer[i] == '\n'){
      memcpy(testBuffer,readUartBuffer,BufferSize);
      memset(readUartBuffer,'\0',BufferSize);
      break;
    }
  }
}



void checkPending(){
  uint8_t flag = 0;
  uint8_t server;
  uint8_t client;
  uint8_t dataByte[2];
  uint8_t intByte;
  uint8_t j = 0;
  if(strncmp(testBuffer,wind55, strlen(wind55))==0){
    printf("\r\ntrue pending\r\n");
    for(uint8_t i = 22; i < sizeof(testBuffer); i++){
      if(testBuffer[i] == '\n'){
        flag = 0;
        break;
      }
      if(testBuffer[i] ==':'){
        flag++;
        continue;
      }
      if(flag == 0){
        server = testBuffer[i];
        
      }
      if(flag == 1){
        client = testBuffer[i];
      }
      if(flag == 2){
        dataByte[j] = testBuffer[i];
        j++;
      }
      if(flag == 3){
        break;
      }
    }
    intByte = atoi(dataByte);
    readData(server,client,intByte);
  }
  
}

void readData(uint8_t server, uint8_t client, uint8_t byte){
  sendDisplay(0,0,0x01);
  transmitWifi(commandSocket);
  recData();
  static char socketClear[]="AT+S.SOCKDC=0,0\r\n";
  traWifi(socketClear);
  translateBuffer();
  
}

void recData(){
  readUartBuffer[0] = '\0';
  static uint8_t i = 0;
  static uint8_t flag = 0;
  for( i = 0; i < BufferSize; i++){
    if(HAL_UART_Receive_IT(&huart1, (uint8_t *)&readUartBuffer[i], 1)!=HAL_OK){
      printf("\r\nerror receive\r\n");
    }
    while(huart1.RxState != HAL_UART_STATE_READY);
    if(readUartBuffer[0] == '\0'){
      i = -1;
      continue;
    }
    if(readUartBuffer[i] == '\n'){
      i = -1;
      if(strncmp(readUartBuffer,reading,strlen(reading))==0){
        flag = 1;
        memset(readUartBuffer,'\0',BufferSize);
        continue;
      }
      if(flag == 1){
        memcpy(testBuffer,readUartBuffer,BufferSize);
        memset(readUartBuffer,'\0',BufferSize);
        break;
      }
    }
  }
}


void translateBuffer(){
  uint32_t len = strlen(testBuffer);
  memset(svar,'\0',sizeof(svar));
  
  memset(trimmedSvar,'\0',sizeof(trimmedSvar));
  memcpy(svar,testBuffer,len-9);
  switch(svar[0]) {
    case 'w':
      for(int i = 0; i < BufferSize - 6; i++) {
        trimmedSvar[i] = svar[i+6];
      }
      break;
    case 'c':
      sendDisplay(0,0,0x01);
      return;
      break;
  }
//  for(int i = 0; i < strlen(svar); i++){
//    if(i == 10){
//      sendDisplay(0,0,0xA0);
//    }
//    if(i == 20){
//      sendDisplay(0,0,0xC0);
//    }
//    if(i == 30){
//      sendDisplay(0,0,0xE0);
//    }
//    sendDisplay(0,1,svar[i]);
//  }
  
    for(int i = 0; i < strlen(trimmedSvar); i++){
    if(i == 10){
      sendDisplay(0,0,0xA0);
    }
    if(i == 20){
      sendDisplay(0,0,0xC0);
    }
    if(i == 30){
      sendDisplay(0,0,0xE0);
    }
    sendDisplay(0,1,trimmedSvar[i]);
  }
}

void clearDisplay(){
//  for(int i = 0; i < 40; i++){
//    sendDisplay(0,1,' ');
//  }
}

void traWifi(char* command){
  if (HAL_UART_Transmit(&huart1, (uint8_t *)command, strlen(command), 5000) != HAL_OK) {
    printf("\r\n Error on transmit");
  }
  
}