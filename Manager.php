<?php

namespace RuCenterApi;

use RuCenterApi\entities\ExpiringService;
use RuCenterApi\entities\ProlongService;
use RuCenterApi\operations\DoProlongServices;
use RuCenterApi\operations\GetExpiringServices;

/**
 * RuCenterApi SimpleRequest Api Client
 */
class Manager
{
    private $cUrlDefaultOptions;
    private $login;
    private $password;

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
     * @return ExpiringService[]
     */
    public function getExpiringDomains()
    {
        $expiringDomains = new GetExpiringServices();

        return $expiringDomains->setLogin($this->login)
            ->setPassword($this->password)
            ->setDefaultCurlOpt($this->cUrlDefaultOptions)
            ->run();
    }

    /**
     * Продлевает услуги
     * @param ProlongService[] $prolongServices
     * @return int
     */
    public function prolongServices($prolongServices)
    {
        $doProlong = new DoProlongServices();
        return $doProlong->setLogin($this->login)
            ->setPassword($this->password)
            ->setDefaultCurlOpt($this->cUrlDefaultOptions)
            ->setProlongServices($prolongServices)
            ->run();
    }
}