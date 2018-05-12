#ifndef _READWIFI_
#define _READWIFI_
void readFromSocket();
void readUartIT();
void HAL_UART_RxCpltCallback(UART_HandleTypeDef *UartHandle);
void clearBufferIT();
void uartSET(uint8_t k);
void recWifi();
#endif