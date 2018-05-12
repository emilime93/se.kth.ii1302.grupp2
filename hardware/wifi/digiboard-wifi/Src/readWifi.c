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

#define BufferSize 40
ITStatus UartReady = RESET;
UART_HandleTypeDef UartHandle;
static char commandSocket[3][20];
static uint8_t readUartBuffer[BufferSize];

void recWifi(){
    if(HAL_UART_Receive_IT(&huart1, (uint8_t *)&readUartBuffer,BufferSize)!=HAL_OK){
      printf("\r\nerror receive\r\n");
    }
    while(UartReady != SET);
    UartReady = RESET;
   
}

void readFromSocket(){
  sprintf(commandSocket[0], "AT+S.SOCKDR=0,0,0\r\n");
  transmitWifi(commandSocket[0]);
}

void clearBufferIT(){
  for(int j = 0; j < sizeof(readUartBuffer); j++){
    readUartBuffer[j] = '\0';
  }
}

/**
* @brief Rx Transfer completed callback
* @param UartHandle: UART handle
* @note This example shows a simple way to report end of IT Rx transfer, and
* you can add your own implementation.
* @retval None
*/
void HAL_UART_RxCpltCallback(UART_HandleTypeDef *UartHandle)
{
/* Set transmission flag: trasfer complete*/
  UartReady = SET;
}