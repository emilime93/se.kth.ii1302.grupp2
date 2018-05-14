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
static uint8_t commandSocket[] = "AT+S.SOCKDR=0,0,0\r\n";
static uint8_t readUartBuffer[BufferSize];
static uint8_t testBuffer[BufferSize];
static uint8_t wind55[]="+WIND:55";


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
      printf("%s%s", readUartBuffer,"\r\n");
      memset(readUartBuffer,'\0',BufferSize);
      break;
    }
  }
}


void checkPending(){
  if(strncmp(testBuffer,wind55, strlen(wind55))==0){
    printf("true pending");
  }
}


void readData(){
  transmitWifi(commandSocket);
  recWifi();
}