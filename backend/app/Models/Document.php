<?php

namespace App\Models;

use App\Models\Interfaces\DocumentInterface;
use App\Rules\CNPJ;
use App\Rules\CPF;
use Illuminate\Validation\Rule;
use App\Utils\Enums\GeneralTypes;

/**
 * Class Document
 * @package App
 */
class Document extends ModelBase implements DocumentInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'cpf',
        'cnpj',
        'status'
    ];

    protected $attributes = [
        "status" => "enable"
    ];

    /**
     * @param null $id
     *
     * @return array
     */
    public function rules($id = null): array
    {
        $id        = empty($id) ? "" : ",".$id;
        $sometimes = empty($id) ? "" : "sometimes|";

        $attributes = [
            'cpf'    => [$sometimes,"unique:documents,cpf", "required_if:cnpj,", "digits_between:11,11", new CPF],
            'cnpj'   => [$sometimes,"unique:documents,cnpj", "required_if:cpf,", "digits_between:14,14", new CNPJ],
            'status' => [$sometimes, Rule::in(GeneralTypes::getStatus())]
        ];

        return $attributes;
    }

    /**
     * @return array
     */
    public function getFullDetails(): array
    {
        return [
            "status"     => $this->status,
            "cnpj"       => $this->cnpj,
            "cpf"        => $this->cpf,
            "created_at" => $this->getDateTimeStringFrom("created_at"),
            "updated_at" => $this->getDateTimeStringFrom("updated_at"),
        ];
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function getSearchParams(array $data): array
    {
        $queryData = [];

        if (!empty($data["status"])) {
            $queryData["status"] = $data["status"];
        }

        if (!empty($data["cpf"])) {
            $queryData["cpf"] = $data["cpf"];

            return $queryData;
        }

        if (!empty($data["cnpj"])) {
            $queryData["cnpj"] = ["cnpj", "like", "%".$data["cnpj"]];

            return $queryData;
        }

        return $queryData;
    }

    /**
     * @return array
     */
    public function getCPFRule(): array
    {
        return [
            'cpf' => ["digits_between:11,11", new CPF],

        ];
    }

    /**
     * @return array
     */
    public function getCNPJRule(): array
    {
        return [
            'cnpj' => ["digits_between:14,14", new CNPJ],
        ];
    }
}
