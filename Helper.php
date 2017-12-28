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
     * Разбирает строку строку ответа сервиса RuCenter в массив
     * @param string $result
     * @return array
     */
    public static function getArrayResult($result)
    {
        $data = [];
        $count = 0;
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $result) as $line) {
            $matches = [];
            if (preg_match('/[[a-z]*]/', $line, $matches)) {
                $count++;
            }
            if (preg_match('/(\S*):(\S*)/', $line, $matches) && count($matches) === 3) {
                if ($matches[2] === '') {
                    continue;
                }
                $data[$count][$matches[1]] = $matches[2];
            }
        }

        return $data;
    }

    /**
     * Возвращает строку для запроса
     * @param string $headerBlock
     * @param string $bodyBlock
     * @return string
     */
    public static function getRequestString($headerBlock, $bodyBlock)
    {
        return 'SimpleRequest=' . rawurlencode($headerBlock.$bodyBlock);
    }

    /**
     * Возвращает строковое представление блока запроса
     * @param array $param
     * @param string $blockName
     * @return string
     */
    public static function getBlock($param, $blockName = ''){
        $block = '';
        if (!empty($blockName)){

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