<?php declare(strict_types=1);

namespace App\Repositories;

use App\Utils\HandleErrors\ErrorMessageInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\InvalidResourceException;

/**
 * Class BaseRepository
 * @package App\Repository
 */
class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var ErrorMessageInterface
     */
    protected $errorMsg;

    /**
     * BaseRepository constructor.
     *
     * @param ErrorMessageInterface $errorMessage
     */
    public function __construct(ErrorMessageInterface $errorMessage)
    {
        $this->errorMsg = $errorMessage;
    }

    public function isOnlineMysql()
    {
        try {

            DB::connection()->getPdo();

        } catch (\PDOException $exception) {
            $msg = $this->errorMsg->getErrorMessage("error",
                                          "MySQL Database is unavailable!");
            throw new \PDOException($msg);
        }
    }

    /**
     * @param array $content
     *
     * @return mixed
     * @throws \Exception
     */
    public function create(array $content)
    {
        $this->isOnlineMysql();

        try {
             return $this->model::create($content);
        } catch (QueryException $e) {
            $msg = $this->errorMsg->getErrorMessage("error",
                                                    "Error trying to record data on MySQL!");
            throw new \Exception($msg);
        }
    }

    /**
     * @param array $content
     * @param int   $rows
     *
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function allBy(array $content, $rows = 10)
    {
        if (empty($content)) {
            return $this->model::all()->take($rows);
        }
    }

    /**
     * @param $id
     *
     * @return int|mixed
     * @throws \Exception
     */
    public function delete($id)
    {
        $status = $this->model::destroy($id);

        if (!$status) {
            throw new \Exception("Record does not exist!");
        }

        return $status;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        $this->isOnlineMysql();

        $data = $this->model::find($id);

        if (!$data) {
            $msg = $this->errorMsg->getErrorMessage("fail",
                                                    "No records with this ID!");
            throw new InvalidResourceException($msg);
        }

        return $data;
    }

    /**
     * @param       $id
     * @param array $content
     *
     * @return mixed
     * @throws \Exception
     */
    public function update($id, array $content)
    {
        $this->isOnlineMysql();

        $register = $this->model::find($id);

        if (empty($register)) {
            $msg = $this->errorMsg
                        ->getErrorMessage("error",
                                          "There is not register to this ID!");

            throw new NotFoundHttpException($msg);
        }

        try {
            $register->update($content);

            return $register;
        } catch (QueryException $e) {
            $msg = $this->errorMsg
                        ->getErrorMessage("error",
                                          "Error trying to record data on MySQL!");

            throw new \Exception($msg);
        }
    }
}
