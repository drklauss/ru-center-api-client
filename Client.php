<?php

namespace Ns\RuCenterApi;

use Ns\RuCenterApi\entities\ExpiringDomain;
use Ns\RuCenterApi\entities\ProlongService;

class Client
{
    /** @var array */
    private $cUrlDefaultOptions;
    private $login;
    private $password;

    public static $TEST_LOGIN = '370/NIC-REG';
    public static $TEST_PASSWORD = 'dogovor';

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
        $this->cUrlDefaultOptions = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_AUTOREFERER => true,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_MAXREDIRS => 1,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_URL => 'https://www.nic.ru/dns/dealer',
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type:application/x-www-form-urlencoded;charset=koi-8'],
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)',
        ];
    }

    /**
     * Возвращает информацию по доменам, действие которых заканчивается
     * @throws \LogicException
     * @return ExpiringDomain[]
     */
    public function getExpiringDomains()
    {
        $ch = curl_init();
        curl_setopt_array($ch, $this->cUrlDefaultOptions);
        $headerBlock = [
            'lang' => 'ru',
            'login' => $this->login . '/NIC-REG',
            'password' => $this->password,
            'request' => 'service',
            'operation' => 'search',
            'request-id' => Helper::generateRequestId()
        ];
        $requestBlock = [
            'state' => 0, // ищем неоплаченные только
            'service' => 'domain', // тип услуги "Домен"
            'service-objects-limit' => 1000, // Лимит на получение - 1000
        ];
        $header = Helper::getBlock($headerBlock);
        $body = Helper::getBlock($requestBlock, 'service');

        curl_setopt($ch, CURLOPT_POSTFIELDS, Helper::getRequestString($header, $body));
        $result = curl_exec($ch);
        curl_close($ch);
        $resArr = Helper::getArrayResult($result);

        return ExpiringDomain::createFromArray($resArr);
    }

    /**
     * Продлевает услуги
     * @param ProlongService[] $prolongServices
     */
    public function prolongServices($prolongServices)
    {
        $ch = curl_init();
        curl_setopt_array($ch, $this->cUrlDefaultOptions);
        $headerBlock = [
            'lang' => 'ru',
            'login' => $this->login . '/NIC-REG',
            'password' => $this->password,
            'request' => 'order',
            'operation' => 'create',
            'request-id' => Helper::generateRequestId()
        ];
        $body = '';
        foreach ($prolongServices as $prolongService) {
            $requestBlock[] = [
                'acc-rec' => $prolongService->serviceId, // ищем неоплаченные только
                'action' => 'domain', // тип услуги "Домен"
                'domain' => $prolongService->domain, // Лимит на получение - 1000
                'prolong' => $prolongService->prolong,
                'service' => 'domain',
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