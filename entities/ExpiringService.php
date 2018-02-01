<?php

namespace RuCenterApi\entities;

use DateTime;
use RuCenterApi\Helper;

/**
 * Class ExpiringDomain
 * Услуга, требующая продления
 */
class ExpiringService
{
    /**
     * Флаг продления услуги
     * 1 - услуга помечена для продления на следующий учетный период
     * 0 - не помечена
     * @var int
     */
    public $prolongFlag;

    /**
     * Стоимость услуги
     * @var float
     */
    public $extensionAmount;

    /**
     * Название домена в верхнем регистре латинскими буквами или Punycode
     * @var string
     */
    public $domain;

    /**
     * Название домена в формате IDN
     * @var string
     */
    public $domainIDN;

    /**
     * Начало действия новой услуги
     * @var DateTime
     */
    public $periodStartDate;

    /**
     * Окончание действия новой услуги
     * @var DateTime
     */
    public $periodEndDate;

    /**
     * Текущая услуга оплачена по...
     * @var DateTime
     */
    public $payedTill;

    /**
     * Внутренний ID услуги
     * @var int
     */
    public $serviceId;

    /**
     * Состояние услуги
     * @var int
     */
    public $serviceState;

    /**
     * Контракт, к которому привязан домен
     * @var string
     */
    public $subjectContract;

    /**
     * Создает и возвращает массив экземпляров текущего класса
     * @param  array $data
     * @return ExpiringService[]
     */
    public static function createFromArray(array $data)
    {
        $expiringServices = [];
        foreach ($data as $oneService) {
            $expiringService = new self();
            $expiringService->prolongFlag = isset($oneService['prolong-flag']) ? (int) $oneService['prolong-flag'] : null;
            $expiringService->extensionAmount = isset($oneService['sum']) ? Helper::correctServiceSum($oneService['sum']) : null;
            $expiringService->domain = isset($oneService['domain']) ? $oneService['domain'] : null;
            $expiringService->domainIDN = isset($oneService['idn-domain']) ? iconv('KOI8-R', 'UTF-8', $oneService['idn-domain']) : null;
            $expiringService->periodStartDate = isset($oneService['period-start-date']) ? DateTime::createFromFormat('d.m.Y', $oneService['period-start-date']) : null;
            $expiringService->periodEndDate = isset($oneService['period-end-date']) ? DateTime::createFromFormat('d.m.Y', $oneService['period-end-date']) : null;
            $expiringService->payedTill = isset($oneService['payed-till']) ? DateTime::createFromFormat('d.m.Y', $oneService['payed-till']) : null;
            $expiringService->serviceId = isset($oneService['service-id']) ? (int) $oneService['service-id'] : null;
            $expiringService->serviceState = isset($oneService['service-state']) ? (int) $oneService['service-state'] : null;
            $expiringService->subjectContract = isset($oneService['subject-contract']) ? $oneService['subject-contract'] : null;
            if ($expiringService->isValid()) {
                $expiringServices[] = $expiringService;
            }
        }

        return $expiringServices;
    }

    /**
     * Проверка класса на валидность
     * @return bool
     */
    private function isValid()
    {
        return $this->prolongFlag !== null &&
            $this->extensionAmount !== null &&
            $this->domain !== null &&
            $this->domainIDN !== null &&
            $this->periodStartDate !== null &&
            $this->periodEndDate !== null &&
            $this->serviceId !== null &&
            $this->serviceState !== null;
    }
}