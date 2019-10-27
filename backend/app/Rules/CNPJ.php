<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class CNPJ
 * @package App\Rules
 */
class CNPJ implements Rule
{
    /**
     * @var string
     */
    private $msg;

    /**
     * @param string $attribute
     * @param mixed  $cnpj
     *
     * @return bool|void
     */
    public function passes($attribute, $cnpj)
    {
        // Valida tamanho
        if (strlen($cnpj) != 14)
        {
            $this->setMessage('O CNPJ deve possuir 14 digitos.');
            return false;
        }

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
        {
            $this->setMessage('O CNPJ não deve possuir sequencias iguais, ex. 11111111...');
            return false;
        }

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
        {
            $this->setMessage('CNPJ inválido.');
            return false;
        }

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj{13} == ($resto < 2 ? 0 : 11 - $resto)) {
            return true;
        }

        $this->setMessage('CNPJ inválido.');
        return false;

    }

    /**
     * @param string $msg
     */
    private function setMessage(string $msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return array|string
     */
    public function message()
    {
        return $this->msg;
    }
}
