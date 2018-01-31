<?php

namespace RuCenterApi;

use DateTime;

class Helper
{
    /**
     * Генерирует валидный request-id для запроса
     * @return string
     */
    public static function generateRequestId()
    {
        $date = new DateTime();
        $dateStr = $date->format('YmdHis');

        return $dateStr . getmypid() . '@nodasoft.com';
    }

    /**
     * Возвращает строку для запроса
     * @param string $headerBlock
     * @param string $bodyBlock
     * @return string
     */
    public static function getRequestString($headerBlock, $bodyBlock)
    {
        return 'SimpleRequest=' . rawurlencode($headerBlock . $bodyBlock);
    }

    /**
     * Возвращает строковое представление блока запроса
     * @param array $param
     * @param string $blockName
     * @return string
     */
    public static function getBlock($param, $blockName = '')
    {
        $block = '';
        if (!empty($blockName)) {
            $block .= "\r\n[{$blockName}]\r\n";
        }
        foreach ($param as $k => $v) {
            $block .= "{$k}:{$v}\r\n";
        }

        return $block;
    }

    /**
     * Коррекция стоимости услуги
     * @param string $sum
     * @return float
     */
    public static function correctServiceSum($sum)
    {
        $matches = [];
        if (preg_match('/\d+.\d+/', $sum, $matches)) {
            return (float) $matches[0];
        }

        return 0.00;
    }
}