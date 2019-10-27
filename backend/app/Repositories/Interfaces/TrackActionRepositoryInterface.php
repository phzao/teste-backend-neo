<?php

namespace App\Repositories\Interfaces;

/**
 * Interface TrackActionRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface TrackActionRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param array $content
     *
     * @return mixed
     */
    public function getOneBy(array $content);
}
