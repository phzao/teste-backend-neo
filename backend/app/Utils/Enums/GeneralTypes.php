<?php

namespace App\Utils\Enums;

/**
 * Class GeneralTypes
 */
abstract class GeneralTypes
{
    const STATUS_ENABLE  = "enable";
    const STATUS_BLOCKED = "blocked";
    const STATUS_DISABLE = "disable";

    const TYPE_CPF  = "cpf";
    const TYPE_CNPJ = "cnpj";

    /**
     * @return array
     */
    static public function getStatus()
    {
        return [
            self::STATUS_ENABLE,
            self::STATUS_BLOCKED,
            self::STATUS_DISABLE
        ];
    }

    /**
     * @return array
     */
    static public function getTypes()
    {
        return [
            self::TYPE_CPF,
            self::TYPE_CNPJ
        ];
    }
}
