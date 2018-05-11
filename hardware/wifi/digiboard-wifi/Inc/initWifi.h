#ifndef _INITWIFI_
#define _INITWIFI_
void transmitWifi(char* commandBuffer);
void receiveWifi();
void ackWifi();
void turnOffEcho();
void sendCommands();
void setupSocket();
char sendReceiverBuffer();
void clearBuffer();
#endif