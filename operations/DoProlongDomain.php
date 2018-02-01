<?php

namespace RuCenterApi\operations;

use RuCenterApi\entities\ExpiringService;
use RuCenterApi\entities\ProlongDomain;
use RuCenterApi\Helper;

/**
 * Операция продления услуг
 * Теоретически возможно продление не только домена, а любой услуги
 */
class DoProlongDomain extends Operation
{
    /**
     * Услуга для продления
     * @var ProlongDomain
     */
    private $prolongDomain;

    /**
     * Сеттер услуг для продления
     * @param ProlongDomain $service
     * @return DoProlongDomain
     */
    public function setProlongDomain(ProlongDomain $service)
    {
        $this->prolongDomain = $service;

        return $this;
    }

    /**
     * Запускает операцию продления
     * @return int
     */
    public function run()
    {
        $ch = curl_init();
        curl_setopt_array($ch, $this->cUrlOptDefault);
        $headerBlock = [
            'lang' => 'ru',
            'login' => $this->login,
            'subject-contract' => $this->prolongDomain->subjectContract,
            'password' => $this->password,
            'request' => 'order',
            'operation' => 'create',
            'request-id' => Helper::generateRequestId()
        ];
        $requestBlock = [
            'action' => 'prolong',
            'service' => 'domain',
            'domain' => $this->prolongDomain->domain,
            'prolong' => $this->prolongDomain->prolong,
        ];
        $body = Helper::getBlock($requestBlock, 'order-item');
        $header = Helper::getBlock($headerBlock);
        curl_setopt($ch, CURLOPT_POSTFIELDS, Helper::getRequestString($header, $body));
        $result = curl_exec($ch);
        curl_close($ch);

        return $this->getResponseCode($result);
    }

    /**
     * Разбирает строку строку ответа сервиса в массив
     * @param string $result
     * @return int
     */
    private function getResponseCode($result)
    {
        if (preg_match('/State:\W(\d{3})/', $result, $matches) && count($matches) === 2) {
            return (int) $matches[1];
        }

        return 500;
    }
}