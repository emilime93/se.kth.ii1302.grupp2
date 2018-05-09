/*
@Author: Elias Chahine
@Date: 2018-05-04
@Note: This file contains methods for wifi module for initialization.
*/


#include "usart.h"

void readSocket(){
  int k = 1;
  int j = 0;
  static char* buffer[40];
  char* commandBuffer[6];
  commandBuffer[0] = "AT+S.SOCKDL=0";
  commandBuffer[1] = "AT+S.SOCKDQ=0,0";
  commandBuffer[2] = "AT+S.SOCKDR=0,0,0";
  commandBuffer[3] = "AT+S.SOCKDC=0,0";
  int i = 0;
  for(i = 0; i < sizeof(commandBuffer); i++){
    if (HAL_UART_Transmit(&huart1,(uint8_t*) &commandBuffer[i], sizeof(commandBuffer[i]), 5000) != HAL_OK) {
      printf("Error Transmit");
    }
    while(k==1){
      if (HAL_UART_Receive(&huart1, (uint8_t *)&buffer[j], 1, 10000) != HAL_OK) {
        printf("error");
      }
      if(((int)buffer[j]+ (int)buffer[j++])=='\n'){
        k = 0;
      }
    }
  }
}
