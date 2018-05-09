///*
//@Author: Elias Chahine
//@Date: 2018-05-04
//@Note: This file contains methods for wifi module for initialization.
//*/
//#include "main.h"
//#include "stm32f3xx_hal.h"
//#include "spi.h"
//#include "usart.h"
//#include "gpio.h"
//#include "initWifi.h"
//void tranRecWifi(char *commandBuffer){
//  if (HAL_UART_Transmit(&huart1, (uint8_t *)&commandBuffer, strlen(commandBuffer), 5000) != HAL_OK) {
//      printf("\r\nerrorRec");
//    }
//    static char buffer[50];
//  int i = 0;
//  while(i <  sizeof(buffer)){
//    if (HAL_UART_Receive(&huart1, (uint8_t *)&buffer[i], 1, 5000) != HAL_OK) {
//      printf("\r\nerrorRec");
//    }
//    if(buffer[i] == '\n'){
//      break;
//    }
//    i++;
//  }
//  printf("Command OK");
//}
//
////void setupWifi(){
////  static char commandBuffer[11][40];
////  sprintf(commandBuffer[0], "AT+S.WIFI=0\r\n");
////  sprintf(commandBuffer[1], "AT+S.SCFG=ip_hostname,digiboard\r\n");
////  sprintf(commandBuffer[2],"AT+S.SCFG=ip_ipaddr,192.168.0.1\r\n");
////  sprintf(commandBuffer[3],"AT+S.SCFG=ip_gw,192.168.0.1\r\n");
////  sprintf(commandBuffer[4],"AT+S.SCFG=ip_dns1,192.168.0.1\r\n");
////  sprintf(commandBuffer[5],"AT+S.SCFG=ip_netmask,255.255.255.0\r\n");
////  sprintf(commandBuffer[6], "AT+S.SSIDTXT=digiboard\r\n");
////  sprintf(commandBuffer[7], "AT+S.SCFG=wifi_priv_mode,0\r\n");
////  sprintf(commandBuffer[8], "AT+S.SCFG=wifi_mode,3\r\n");
////  sprintf(commandBuffer[9], "AT+S.WCFG\r\n");
////  sprintf(commandBuffer[10], "AT+S.WIFI=1\r\n");
//////  sprintf(commandBuffer[11],"AT+S.SOCKDON=1337,t\r\n");
////  for(int j = 0; j < 11; j++){
//////    if(j == 11){
//////      transmitSocket(commandBuffer[j]);
//////    }
//////    else{
////      transmitWifi(commandBuffer[j]);
//////    }
////  }
////}
