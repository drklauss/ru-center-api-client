<?php

namespace RuCenterApi\entities;

/**
 * Class ProlongDomain
 * Домен, который будет продлеваться
 */
class ProlongDomain
{
    /**
     * Контракт, к которому привязан домен
     * @var int
     */
    public $subjectContract;

    /**
     * Название домена в верхнем регистре латинскими буквами или Punycode
     * @var string
     */
    public $domain;

    /**
     * Поле, определяющее срок, на который будет продлен домен
     * @var int
     */
    public $prolong = 1;
}