///*
//@Author: Elias Chahine
//@Date: 2018-05-04
//@Note: This file contains methods for wifi module for initialization.
//*/

#include "main.h"
#include "stdint.h"
#include "stdio.h"
#include "initWifi.h"
#include "usart.h"
#include "string.h"
#include "math.h"
#include "displayMethods.h"
static char commandReceiver[70];
static uint8_t confirmed = 0;


void clearBuffer(){
  for(int j = 0; j < sizeof(commandReceiver); j++){
    commandReceiver[j] = '\0';
  }
}

void transmitWifi(char* command){
  if (HAL_UART_Transmit(&huart1, (uint8_t *)command, strlen(command), 5000) != HAL_OK) {
    printf("\r\n Error on transmit");
  }
}

void receiveWifi(){
  uint8_t i = 0;
  while(i < sizeof(commandReceiver)){
    if(HAL_UART_Receive(&huart1, (uint8_t *)&commandReceiver[i],1,5000)!=HAL_OK){
      printf("\r\nerror receive\r\n");
    }
    if(commandReceiver[i]== '\n'){
      break;
    }
    i++;
  } 
}

void ackWifi(){
  for(int i = 0; i < 70; i++){
    if(commandReceiver[i] == 'A'){
      if(commandReceiver[i+2] == '-'){
        clearBuffer();
        confirmed = 1;
      }
    }
  }
}

void turnOffEcho(){
  static uint8_t c1[]="AT+S.SCFG=console_echo,0\r\n";
  transmitWifi(c1);
  receiveWifi();
  ackWifi();
  if(confirmed == 1){
    confirmed = 0;
    printf("\r\nEcho off");
  }else{
    turnOffEcho();
  }
}

void sendCommands(){
  static char commandBuffer[11][40];
  sprintf(commandBuffer[0], "AT+S.WIFI=0\r\n");
  sprintf(commandBuffer[1], "AT+S.SCFG=ip_hostname,digiboard\r\n");
  sprintf(commandBuffer[2],"AT+S.SCFG=ip_ipaddr,192.168.0.1\r\n");
  sprintf(commandBuffer[3],"AT+S.SCFG=ip_gw,192.168.0.1\r\n");
  sprintf(commandBuffer[4],"AT+S.SCFG=ip_dns1,192.168.0.1\r\n");
  sprintf(commandBuffer[5],"AT+S.SCFG=ip_netmask,255.255.255.0\r\n");
  sprintf(commandBuffer[6], "AT+S.SSIDTXT=digiboard\r\n");
  sprintf(commandBuffer[7], "AT+S.SCFG=wifi_priv_mode,0\r\n");
  sprintf(commandBuffer[8], "AT+S.SCFG=wifi_mode,3\r\n");
  sprintf(commandBuffer[9], "AT+S.WCFG\r\n");
  sprintf(commandBuffer[10], "AT+S.WIFI=1\r\n");
  for(int i = 0; i < 11; i++){
    transmitWifi(commandBuffer[i]);
    receiveWifi();
    ackWifi();
    if(confirmed == 1){
      confirmed = 0;
      printf("\r\nCommand confirmed");
    }
    else{
      break;
    }
  }
}

void setupSocket(){
  static uint8_t commandSocket[]="AT+S.SOCKDON=1337,t\r\n";
  transmitWifi(commandSocket);
  printf("\r\ntransmit socket done");
  clearBuffer();
}