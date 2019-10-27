<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Document;
use App\Services\Uptime\Interfaces\UptimeServiceInterface;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\DocumentRepositoryInterface;
use Illuminate\Validation\ValidationException;

/**
 * Class DocumentController
 * @package App\Http\Controllers
 */
class DocumentController extends Controller
{
    /**
     * @var DocumentRepositoryInterface
     */
    private $repository;

    /**
     * @var UptimeServiceInterface
     */
    private $uptimeService;

    /**
     * DocumentController constructor.
     *
     * @param DocumentRepositoryInterface $repository
     * @param UptimeServiceInterface      $uptimeService
     */
    public function __construct(DocumentRepositoryInterface $repository,
                                UptimeServiceInterface $uptimeService)
    {
        $this->repository    = $repository;
        $this->uptimeService = $uptimeService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {

            $list = $this->repository->allBy($request->all());
            $this->uptimeService->track($request, "read");

            return $this->respond($list);
        } catch(\PDOException $exception) { //db is offline

            $this->setStatusCode(503);
            return $this->respondWithErrors($exception->getMessage());
        } catch (\Exception $exception) { //error on mysql

            $this->setStatusCode(400);
            return $this->respondWithErrors($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        try {

            $record = $this->repository->getById($id);
            $this->uptimeService->track($request, "read");

            return $this->respond($record);
        } catch(\PDOException $exception) { //db is offline

            $this->setStatusCode(503);
            return $this->respondWithErrors($exception->getMessage());
        } catch (\Exception $exception) { //error on mysql

            $this->setStatusCode(400);
            return $this->respondWithErrors($exception->getMessage());
        }
    }

    /**
     * @param Request  $request
     * @param Document $document
     * @param          $cpf
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByCPF(Request $request, Document $document, $cpf)
    {
        try {

            $request->merge(["cpf" => $cpf]);
            $this->validate($request, $document->getCPFRule());
            $record = $this->repository->getByCPF($cpf);
            $this->uptimeService->track($request, "read");

            return $this->respond($record);
        } catch(\PDOException $exception) { //db is offline

            $this->setStatusCode(503);
            return $this->respondWithErrors($exception->getMessage());
        } catch(ValidationException $exception) { //db is offline

            return $this->respondValidationError($exception->errors());
        } catch (\Exception $exception) { //error on mysql

            $this->setStatusCode(400);
            return $this->respondWithErrors($exception->getMessage());
        }
    }

    /**
     * @param Request  $request
     * @param Document $document
     * @param          $cnpj
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByCNPJ(Request $request, Document $document, $cnpj)
    {
        try {
            $request->merge(["cnpj" => $cnpj]);
            $this->validate($request, $document->getCNPJRule());
            $this->uptimeService->track($request, "read");

            $record = $this->repository->getByCNPJ($cnpj);

            return $this->respond($record);
        } catch(\PDOException $exception) { //db is offline

            $this->setStatusCode(503);
            return $this->respondWithErrors($exception->getMessage());
        } catch(ValidationException $exception) { //db is offline

            return $this->respondValidationError($exception->errors());
        } catch (\Exception $exception) { //error on mysql

            $this->setStatusCode(400);
            return $this->respondWithErrors($exception->getMessage());
        }
    }

    /**
     * @param Request  $request
     * @param Document $document
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Document $document)
    {
        try {

            $this->validate($request, $document->rules());
            $this->uptimeService->track($request, "write");

            $record = $this->repository->create($request->all());

            return $this->respondCreated($record);
        } catch(\PDOException $exception) { //db is offline
            $this->setStatusCode(503);

            return $this->respondWithErrors($exception->getMessage());
        } catch (ValidationException $e) { //object validation is failed

            return $this->respondValidationError($e->errors());
        } catch (\Exception $exception) { //error on mysql/redis
            $this->setStatusCode(400);

            return $this->respondWithErrors($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {

            $this->repository->update($id, $request->all());
            $this->uptimeService->track($request, "update");

            return $this->respondUpdatedResource();
        } catch(\PDOException $exception) { //db is offline

            $this->setStatusCode(503);
            return $this->respondWithErrors($exception->getMessage());
        } catch (\Exception $exception) { //error on mysql

            $this->setStatusCode(400);
            return $this->respondWithErrors($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delBlacklist(Request $request, $id)
    {
        try {
            $this->repository->delFromBlacklist($id);
            $this->uptimeService->track($request, "update");

            return $this->respondUpdatedResource();
        } catch(\PDOException $exception) { //db is offline

            $this->setStatusCode(503);
            return $this->respondWithErrors($exception->getMessage());
        } catch (\Exception $exception) { //error on mysql

            $this->setStatusCode(400);
            return $this->respondWithErrors($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addBlacklist(Request $request, $id)
    {
        try {

            $this->repository->addToBlacklist($id);
            $this->uptimeService->track($request, "update");

            return $this->respondUpdatedResource();
        } catch(\PDOException $exception) { //db is offline

            $this->setStatusCode(503);
            return $this->respondWithErrors($exception->getMessage());
        } catch (\Exception $exception) { //error on mysql

            $this->setStatusCode(400);
            return $this->respondWithErrors($exception->getMessage());
        }
    }
}
