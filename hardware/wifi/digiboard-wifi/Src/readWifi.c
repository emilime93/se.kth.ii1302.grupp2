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

ITStatus UartReady = RESET;
#define BufferSize 40
UART_HandleTypeDef UartHandle;
static char commandSocket[3][20];
static uint8_t readUartBuffer[40];
uint8_t it = 1;

void recWifi(){
  uint8_t i = 0;
  while(i < sizeof(readUartBuffer)){
    if(HAL_UART_Receive(&huart1, (uint8_t *)&readUartBuffer[i],1,5000)!=HAL_OK){
      printf("\r\nerror receive\r\n");
    }
    if(readUartBuffer[i]== '\n'){
      break;
    }
    i++;
  } 
}

void readFromSocket(){
  sprintf(commandSocket[0], "AT+S.SOCKDR=0,0,0\r\n");
  transmitWifi(commandSocket[0]);
  
}

void clearBufferIT(){
  printf(readUartBuffer);
  printf("\r\n");
  for(int j = 0; j < sizeof(readUartBuffer); j++){
    readUartBuffer[j] = '\0';
  }
}