/**
******************************************************************************
* @file displayMethods.c
* @author Elias Chahine
* @date 2018-05-02
* @version 1.0
* @brief Methods for the display.
* 
******************************************************************************
*/

#include "spi.h"
#include "stdint.h"
#include "stdio.h"
#include "stm32f3xx_hal.h"
#include "main.h"
#include "gpio.h"
#include "displayMethods.h"


/** 
@brief  Display initialization
@param  void
@note   This method starts up the screen and resets it.
@return none 
@author Elias Chahine
*/
void displayInit(void){
  sendDisplay(0,0,0x3A);
  sendDisplay(0,0,0x09);
  sendDisplay(0,0,0x06);
  sendDisplay(0,0,0x1E);
  sendDisplay(0,0,0x39);
  sendDisplay(0,0,0x1B);
  sendDisplay(0,0,0x6E);
  sendDisplay(0,0,0x56);
  sendDisplay(0,0,0x7A);
  sendDisplay(0,0,0x38);
  sendDisplay(0,0,0x0F);
  sendDisplay(0,0,0x01);
}

/** 
@brief  Make Instructions
@param  uint8_t RW, uint8_t RS, uint8_t data
@note   This method lets the user make instructions that goes to the screen
it just need to put in RW for read or write and RS (look
in the datasheet for the display) data need to come in as 8 bit, normal how
you would write it. The switching of the data will be made in method.
@return none 
@author Elias Chahine
*/
void sendDisplay(uint8_t RW, uint8_t RS, uint8_t data){
  uint8_t first;
  uint8_t second;
  uint8_t third;
  uint8_t dataByte [3];
  uint8_t firstByte = 0x1F; //0001 1111
  uint8_t secondByte = 0x00; // 1111 0000
  uint8_t thirdByte = 0x00;  // 1111 0000
  RW = RW << 5; //0000 0001 -> 0010 0000
  firstByte = firstByte | RW;
  RS = RS << 6; //0000 0001 -> 0100 0000
  firstByte = firstByte | RS;
  first = firstByte;
  
  // 1111 1111 -> 0000 1111
  secondByte = secondByte | (data & 0x0F);
  second = secondByte;
  
  data = data & 0xF0; // 1111 1111 -> 1111 0000
  data = data >> 4; // 1111 0000 -> 0000 1111
  thirdByte = thirdByte | data;
  third = thirdByte;
  
  dataByte [0] = first;
  dataByte [1] = second;
  dataByte [2] = third;
  //Opens and closes the pin so user can send the instructions to the screen

  HAL_SPI_Transmit(&hspi1, dataByte,3,1000);

}
