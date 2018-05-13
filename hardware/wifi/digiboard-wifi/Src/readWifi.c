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

#define BufferSize 33
static char commandSocket[3][20];
static uint8_t readUartBuffer[BufferSize];

void recWifi(){
  if(HAL_UART_Receive_IT(&huart1, (uint8_t *)&readUartBuffer,BufferSize)!=HAL_OK){
    printf("\r\nerror receive\r\n");
  }
  while(huart1.RxState != HAL_UART_STATE_READY);
}

void readFromSocket(){
  sprintf(commandSocket[0], "AT+S.SOCKDR=0,0,0\r\n");
  transmitWifi(commandSocket[0]);
}

void clearBufferIT(){
  for(int i = 0; i < BufferSize; i++){
    readUartBuffer[i] = '\0';
  }
}
void checkBuffer(){
  //  for(int i = 0; i < BufferSize; i++){
  //    if(readUartBuffer[i]=='\n'){
  //      if(readUartBuffer[0] == '+'){
  //        printf("true\r\n");
  //        break;
  //      }
  //    }
  //  }
  if(strcmp(readUartBuffer,"+WIND:29:DHCP Reply:192.168.0.2\r\n") == 0){
    printf("true\r\n");
  }
  else{clearBufferIT();}
}
