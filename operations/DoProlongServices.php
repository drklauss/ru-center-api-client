<?php

namespace RuCenterApi\operations;

use RuCenterApi\entities\ExpiringService;
use RuCenterApi\entities\ProlongService;
use RuCenterApi\Helper;

/**
 * Операция продления услуг
 * Теоретически возможно продление не только домена, а любой услуги
 */
class DoProlongServices extends Operation
{
    /**
     * Услуги для продления
     * @var ProlongService[]
     */
    private $prolongServices;

    /**
     * Сеттер услуг для продления
     * @param $services
     * @return DoProlongServices
     */
    public function setProlongServices(ProlongService $services)
    {
        $this->prolongServices = $services;

        return $this;
    }

    /**
     * Запускает операцию продления
     * @return ExpiringService[]
     */
    public function run()
    {
        $ch = curl_init();
        curl_setopt_array($ch, $this->cUrlOptDefault);
        $headerBlock = [
            'lang' => 'ru',
            'login' => $this->login,
            'password' => $this->password,
            'request' => 'order',
            'operation' => 'create',
            'request-id' => Helper::generateRequestId()
        ];
        $body = '';
        foreach ($this->prolongServices as $prolongService) {
            $requestBlock[] = [
                'acc-rec' => $prolongService->serviceId, // ищем неоплаченные только
                'action' => 'domain', // тип услуги "Домен"
                'domain' => $prolongService->domain, // Лимит на получение - 1000
                'prolong' => $prolongService->prolong,
                'service' => 'domain',
                'template' => 'prolong',
            ];
            $body .= Helper::getBlock($requestBlock, 'order-item');
        }
        $header = Helper::getBlock($headerBlock);
        curl_setopt($ch, CURLOPT_POSTFIELDS, Helper::getRequestString($header, $body));
        $result = curl_exec($ch);
        echo $result;
        exit;
        curl_close($ch);
        $resArr = Helper::getArrayResult($result);

        return $resArr;
    }
}