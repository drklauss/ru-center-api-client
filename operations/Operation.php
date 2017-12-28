<?php

namespace RuCenterApi\operations;

/**
 * Class Client
 */
class Operation
{
    protected $cUrlOptDefault;
    protected $login;
    protected $password;

    /**
     * Сеттер логина
     * @param string $login
     * @return $this
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Сеттер пароля
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }


    /**
     * Сеттер настроек по умолчанию для cURL
     * @param array $curlOpt
     * @return $this
     */
    public function setDefaultCurlOpt($curlOpt)
    {
        $this->cUrlOptDefault = $curlOpt;

        return $this;
    }
}