<?php

namespace App\Repositories;

use App\Models\Document;
use App\Repositories\Interfaces\DocumentRepositoryInterface;
use App\Utils\HandleErrors\ErrorMessageInterface;

/**
 * Class DocumentRepository
 * @package App\Repositories
 */
class DocumentRepository extends BaseRepository implements DocumentRepositoryInterface
{
    /**
     * DocumentRepository constructor.
     *
     * @param ErrorMessageInterface $errorMessage
     */
    public function __construct(ErrorMessageInterface $errorMessage)
    {
        parent::__construct($errorMessage);
        $this->model = new Document();
    }

    /**
     * @param array $content
     *
     * @return mixed
     * @throws \Exception
     */
    public function create(array $content)
    {
        $document = parent::create($content);

        return $document->getFullDetails();
    }

    /**
     * @param string $cpf
     *
     * @return mixed
     */
    public function getByCPF(string $cpf)
    {
        return $this->model::where('cpf','=', $cpf)->get();
    }

    /**
     * @param string $cnpj
     *
     * @return mixed
     */
    public function getByCNPJ(string $cnpj)
    {
        return $this->model::where('cnpj','=', $cnpj)->get();
    }

    /**
     * @param array $content
     * @param int   $rows
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]|mixed
     */
    public function allBy(array $content, $rows = 10)
    {
        if (!empty($content["rows"])) {
            $rows = $content["rows"];
            unset($content["rows"]);
        }

        if (empty($content)) {
            return parent::allBy($content, $rows);
        }

        $queryString = $this->model->getSearchParams($content);

        if (count($queryString) < 2) {
            return $this->model::where($queryString)->get();
        }

        $query = $this->model::where(["status" => $queryString["status"]]);

        if (!empty($queryString["cpf"]) )
        {
            $query = $query->where(function ($queryData) use ($queryString) {
                                        $queryData->where('cpf', 'like', '%'.$queryString['cpf'].'%');
                                    });
        }

        if (!empty($queryString["cnpj"])) {
            $query = $query->where(function ($queryData) use ($queryString) {
                $queryData->where('cnpj', 'like', '%'.$queryString['cnpj'].'%');
            });
        }

        return $query
                    ->take($rows)
                    ->get();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function addToBlacklist($id)
    {
        $register = $this->model::find($id);

        $register->setBlacklistStatus();
        $register->update();

        return $register;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delFromBlacklist($id)
    {
        $register = $this->model::find($id);

        $register->unsetBlacklistStatus();
        $register->update();

        return $register;
    }
}
