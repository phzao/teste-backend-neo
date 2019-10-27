<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class CPF
 * @package App\Rules
 */
class CPF implements Rule
{
    /**
     * @var string
     */
    private $msg;

    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool|void
     */
    public function passes($attribute, $value)
    {

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($value) != 11) {

            $this->setMessage('O CPF deve possuir 11 digitos.');
            return false;
        }

        // Verifica se foi informada uma $value de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $value)) {

            $this->setMessage('O CPF não deve possuir sequencias iguais, ex. 11111111...');
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++)
        {
            for ($d = 0, $c = 0; $c < $t; $c++)
            {
                $d += $value{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($value{$c} != $d) {

                $this->setMessage('CPF Inválido.');
                return false;
            }
        }

        return true;
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
