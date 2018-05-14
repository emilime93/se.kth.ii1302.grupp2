#ifndef _READWIFI_
#define _READWIFI_
void readFromSocket();
void readUartIT();
void HAL_UART_RxCpltCallback(UART_HandleTypeDef *UartHandle);
void clearBufferIT();
void recWifi();
void checkPending();
//void traWifi(char* commandBuffer);
void readData(uint8_t server, uint8_t client, uint8_t byte);
void recData();
void translateBuffer();
void clearDisplay();
void traWifi(char* command);
#endif