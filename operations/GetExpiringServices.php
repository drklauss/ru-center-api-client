<?php

namespace RuCenterApi\operations;

use RuCenterApi\entities\ExpiringService;
use RuCenterApi\Helper;

/**
 * Операция получения данных о услугах, действие которых заканчивается
 * Теоретически возможно получение данных о любых услугах, действие которых заканчивается
 */
class GetExpiringServices extends Operation
{
    /**
     * Запускает операцию получения данных по доменам
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
            'request' => 'service',
            'operation' => 'search',
            'request-id' => Helper::generateRequestId()
        ];
        $requestBlock = [
            'state' => 0, // ищем неоплаченные только
            'service' => 'domain', // тип услуги "Домен"
            'services-limit' => 1000, // Лимит на получение - 1000
        ];
        $header = Helper::getBlock($headerBlock);
        $body = Helper::getBlock($requestBlock, 'service');

        curl_setopt($ch, CURLOPT_POSTFIELDS, Helper::getRequestString($header, $body));
        $result = curl_exec($ch);
        curl_close($ch);
        $resArr = Helper::getArrayResult($result);

        return ExpiringService::createFromArray($resArr);
    }
}