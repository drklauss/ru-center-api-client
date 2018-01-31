<?php

namespace RuCenterApi\entities;

/**
 * Class ProlongService
 * Услуга, которая будет продлеваться
 */
class ProlongService
{
    /**
     * Внутренний ID услуги
     * @var int
     */
    public $serviceId;

    /**
     * Название домена в верхнем регистре латинскими буквами или Punycode
     * @var string
     */
    public $domain;

    /**
     * Поле, определяющее срок, на который будет продлена услуга
     * @var int
     */
    public $prolong = 1;
}