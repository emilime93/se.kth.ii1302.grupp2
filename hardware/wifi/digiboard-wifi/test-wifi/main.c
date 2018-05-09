
/* Includes ------------------------------------------------------------------*/
#include "main.h"
#include "stm32f3xx_hal.h"
#include "spi.h"
#include "usart.h"
#include "gpio.h"

/* USER CODE BEGIN Includes */
#include "displayMethods.h"
#include "string.h"
#include "stdio.h"
#include "math.h"
#include "initWifi.h"

// todo remove rhis 
// ITStatus UartReady = RESET;

void SystemClock_Config(void);

int main(void)
{
  HAL_Init();
  SystemClock_Config();
  
  MX_GPIO_Init();
  MX_SPI1_Init();
  MX_USART1_UART_Init();
  displayInit();
    static char command2[]="AT+S.RESET\r\n";
      if (HAL_UART_Transmit(&huart1, (uint8_t *)&command2, strlen(command2) - 1, 5000) != HAL_OK) {
      printf("\r\n I am trying to transmit this shit");
    }
printf("done");  
  char command1[]="AT+S.SCFG=console_echo,0\r\n";
      if (HAL_UART_Transmit(&huart1, (uint8_t *)&command1, strlen(command1) -1, 5000) != HAL_OK) {
      printf("\r\n I am trying to transmit this shit");
    }
  
  
  static char commandBuffer[12][40];
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
  sprintf(commandBuffer[11],"AT+S.SOCKDON=9325,t\r\n");
  
  for(int j = 0; j < 12; j++){
    if (HAL_UART_Transmit(&huart1, (uint8_t *)&commandBuffer[j], strlen(commandBuffer[j]), 5000) != HAL_OK) {
      printf("\r\n I am trying to transmit this shit");
    }
    static char buffer[50];
    int i = 0;
    while(i <  sizeof(buffer)){
      if (HAL_UART_Receive(&huart1, (uint8_t *)&buffer[i], 1, 5000) != HAL_OK) {
        printf("\r\nerrorRec");
      }
      if(buffer[i] == '\n'){
        break;
      }
      i++;
    }
  }
  
//  for(int k = 0; k < sizeof(buffer); k++){
//    sendDisplay(0,1,buffer[k]);
//  }
  //  setupWifi();
  
  while (1)
  { 
    
    
  }
}


void SystemClock_Config(void)
{
  
  RCC_OscInitTypeDef RCC_OscInitStruct;
  RCC_ClkInitTypeDef RCC_ClkInitStruct;
  RCC_PeriphCLKInitTypeDef PeriphClkInit;
  
  /**Initializes the CPU, AHB and APB busses clocks 
  */
  RCC_OscInitStruct.OscillatorType = RCC_OSCILLATORTYPE_HSE;
  RCC_OscInitStruct.HSEState = RCC_HSE_ON;
  RCC_OscInitStruct.HSIState = RCC_HSI_ON;
  RCC_OscInitStruct.PLL.PLLState = RCC_PLL_NONE;
  if (HAL_RCC_OscConfig(&RCC_OscInitStruct) != HAL_OK)
  {
    _Error_Handler(__FILE__, __LINE__);
  }
  
  /**Initializes the CPU, AHB and APB busses clocks 
  */
  RCC_ClkInitStruct.ClockType = RCC_CLOCKTYPE_HCLK|RCC_CLOCKTYPE_SYSCLK
    |RCC_CLOCKTYPE_PCLK1|RCC_CLOCKTYPE_PCLK2;
  RCC_ClkInitStruct.SYSCLKSource = RCC_SYSCLKSOURCE_HSE;
  RCC_ClkInitStruct.AHBCLKDivider = RCC_SYSCLK_DIV1;
  RCC_ClkInitStruct.APB1CLKDivider = RCC_HCLK_DIV1;
  RCC_ClkInitStruct.APB2CLKDivider = RCC_HCLK_DIV1;
  
  if (HAL_RCC_ClockConfig(&RCC_ClkInitStruct, FLASH_LATENCY_0) != HAL_OK)
  {
    _Error_Handler(__FILE__, __LINE__);
  }
  
  PeriphClkInit.PeriphClockSelection = RCC_PERIPHCLK_USART1;
  PeriphClkInit.Usart1ClockSelection = RCC_USART1CLKSOURCE_PCLK1;
  if (HAL_RCCEx_PeriphCLKConfig(&PeriphClkInit) != HAL_OK)
  {
    _Error_Handler(__FILE__, __LINE__);
  }
  
  /**Configure the Systick interrupt time 
  */
  HAL_SYSTICK_Config(HAL_RCC_GetHCLKFreq()/1000);
  
  /**Configure the Systick 
  */
  HAL_SYSTICK_CLKSourceConfig(SYSTICK_CLKSOURCE_HCLK);
  
  /* SysTick_IRQn interrupt configuration */
  HAL_NVIC_SetPriority(SysTick_IRQn, 0, 0);
}

/* USER CODE BEGIN 4 */

/* USER CODE END 4 */

/**
* @brief  This function is executed in case of error occurrence.
* @param  None
* @retval None
*/
void _Error_Handler(char * file, int line)
{
  /* USER CODE BEGIN Error_Handler_Debug */
  /* User can add his own implementation to report the HAL error return state */
  while(1) 
  {
  }
  /* USER CODE END Error_Handler_Debug */ 
}

#ifdef USE_FULL_ASSERT

/**
* @brief Reports the name of the source file and the source line number
* where the assert_param error has occurred.
* @param file: pointer to the source file name
* @param line: assert_param error line source number
* @retval None
*/
void assert_failed(uint8_t* file, uint32_t line)
{
  /* USER CODE BEGIN 6 */
  /* User can add his own implementation to report the file name and line number,
  ex: printf("Wrong parameters value: file %s on line %d\r\n", file, line) */
  /* USER CODE END 6 */
  
}

#endif

/**
* @}
*/ 

/**
* @}
*/ 

/************************ (C) COPYRIGHT STMicroelectronics *****END OF FILE****/
