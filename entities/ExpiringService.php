<?php

namespace RuCenterApi\entities;

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
     * Начало действия услуги в формате DD.MM.YYYY
     * @var string
     */
    public $periodStartDate;

    /**
     * Окончание действия услуги в формате DD.MM.YYYY
     * @var string
     */
    public $periodEndDate;

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
     * Создает и возвращает массив экземпляров текущего класса
     * @param  array $data
     * @return ExpiringService[]
     */
    public static function createFromArray(array $data)
    {
        $expiringDomains = [];
        foreach ($data as $oneService) {
            $overdueService = new self();
            $overdueService->prolongFlag = isset($oneService['prolong-flag']) ? (int) $oneService['prolong-flag'] : null;
            $overdueService->extensionAmount = isset($oneService['sum']) ? Helper::correctServiceSum($oneService['sum']) : null;
            $overdueService->domain = isset($oneService['domain']) ? $oneService['domain'] : null;
            $overdueService->domainIDN = isset($oneService['idn-domain']) ? $oneService['idn-domain'] : null;
            $overdueService->periodStartDate = isset($oneService['period-start-date']) ? $oneService['period-start-date'] : null;
            $overdueService->periodEndDate = isset($oneService['period-end-date']) ? $oneService['period-end-date'] : null;
            $overdueService->serviceId = isset($oneService['service-id']) ? (int) $oneService['service-id'] : null;
            $overdueService->serviceState = isset($oneService['service-state']) ? (int) $oneService['service-state'] : null;
            if ($overdueService->isValid()) {
                $expiringDomains[] = $overdueService;
            }
        }

        return $expiringDomains;
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