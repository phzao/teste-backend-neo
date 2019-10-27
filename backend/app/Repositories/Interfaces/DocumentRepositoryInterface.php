<?php

namespace App\Repositories\Interfaces;

/**
 * Interface DocumentRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface DocumentRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param string $cpf
     *
     * @return mixed
     */
    public function getByCPF(string $cpf);

    /**
     * @param string $cnpj
     *
     * @return mixed
     */
    public function getByCNPJ(string $cnpj);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function addToBlacklist($id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delFromBlacklist($id);
}
