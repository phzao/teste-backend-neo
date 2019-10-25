<?php declare(strict_types=1);

namespace App\Repositories\Interfaces;

/**
 * Interface BaseRepositoryInterface
 * @package App\Repository
 */
interface BaseRepositoryInterface
{

    public function isOnlineMysql();

    /**
     * @param array $content
     *
     * @return mixed
     */
    public function create(array $content);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getById($id);

    /**
     * @param       $id
     * @param array $content
     *
     * @return mixed
     */
    public function update($id, array $content);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * @param array $filter
     *
     * @return mixed
     */
    public function allBy(array $filter);
}
