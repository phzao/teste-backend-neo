<?php

namespace App\Repositories;

use App\Models\TrackAction;
use App\Utils\HandleErrors\ErrorMessageInterface;
use App\Repositories\Interfaces\TrackActionRepositoryInterface;

/**
 * Class TrackActionRepository
 * @package App\Repositories
 */
class TrackActionRepository extends BaseRepository implements TrackActionRepositoryInterface
{
    /**
     * DocumentRepository constructor.
     *
     * @param ErrorMessageInterface $errorMessage
     */
    public function __construct(ErrorMessageInterface $errorMessage)
    {
        parent::__construct($errorMessage);
        $this->model = new TrackAction();
    }

    /**
     * @param array $content
     *
     * @return mixed
     * @throws \Exception
     */
    public function create(array $content)
    {
        parent::create($content);
    }

    /**
     * @param array $content
     * @param int   $rows
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]|mixed
     */
    public function allBy(array $content, $rows = 100)
    {
        if (!empty($content["rows"])) {
            $rows = $content["rows"];
            unset($content["rows"]);
        }

        return parent::allBy($content, $rows);
    }

    /**
     * @param array $content
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]|mixed
     */
    public function getOneBy(array $content)
    {
        return $this->model::where($content)->get();
    }
}
