<?php

namespace Ns\RuCenterApi\entities;

/**
 * Class ServiceState
 * Состояние услуги
 */
class ServiceState
{
    /** Услуга предоставляется */
    const AVAILABLE = 0;
    /** Услуга временно не предоставляется */
    const TEMP_NOT_AVAILABLE = 1;
    /** Услуга никогда больше не будет предоставляться (в таблице оставлена для истории) */
    const NEVER_BE_AVAILABLE = 2;
    /** Услуга временно не предоставляется, но счет можно выставить */
    const TEMP_NOT_AVAILABLE_BUT_CAN_BE_PAID = 3;
    /** Услуга предоставляется, счет нельзя выставить (организация отказалась платить) */
    const AVAILABLE_BUT_CANNOT_BE_PAID = 4;
}