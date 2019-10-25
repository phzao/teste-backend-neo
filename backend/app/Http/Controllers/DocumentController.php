<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Document;
use App\Repositories\Interfaces\DocumentRepositoryInterface;
use Illuminate\Http\Request;
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
     * DocumentController constructor.
     *
     * @param DocumentRepositoryInterface $repository
     */
    public function __construct(DocumentRepositoryInterface $repository)
    {
        $this->repository = $repository;
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
     * @param Request  $request
     * @param Document $document
     * @param          $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request,
                         Document $document,
                         $id)
    {
        try {

            $request->merge(['id' => $id]);
            $this->validate($request, $document->getRulesID());

            $record = $this->repository->getById($id);

            return $this->respond($record);
        } catch(\PDOException $exception) { //db is offline

            $this->setStatusCode(503);
            return $this->respondWithErrors($exception->getMessage());
        } catch (ValidationException $e) { //object validation is failed

            return $this->respondValidationError($e->errors());
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

            $request->merge(['cpf' => $cpf]);
            $this->validate($request, $document->getCPFRule());

            $record = $this->repository->getByCPF($cpf);

            return $this->respond($record);
        } catch(\PDOException $exception) { //db is offline

            $this->setStatusCode(503);
            return $this->respondWithErrors($exception->getMessage());
        } catch (ValidationException $e) { //object validation is failed

            return $this->respondValidationError($e->errors());
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

            $request->merge(['cnpj' => $cnpj]);
            $this->validate($request, $document->getCPFRule());

            $record = $this->repository->getByCNPJ($cnpj);

            return $this->respond($record);
        } catch(\PDOException $exception) { //db is offline

            $this->setStatusCode(503);
            return $this->respondWithErrors($exception->getMessage());
        } catch (ValidationException $e) { //object validation is failed

            return $this->respondValidationError($e->errors());
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
     * @param Request  $request
     * @param Document $document
     * @param          $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Document $document, $id)
    {
        try {
            $request->merge(['id' => $id]);
            $this->validate($request, $document->getRulesID());

            $this->repository->update($id, $request->all());

            return $this->respondUpdatedResource();
        } catch(\PDOException $exception) { //db is offline

            $this->setStatusCode(503);
            return $this->respondWithErrors($exception->getMessage());
        } catch (ValidationException $e) { //object validation is failed

            return $this->respondValidationError($e->errors());
        } catch (\Exception $exception) { //error on mysql

            $this->setStatusCode(400);
            return $this->respondWithErrors($exception->getMessage());
        }
    }

    /**
     * @param Request  $request
     * @param Document $document
     * @param          $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, Document $document, $id)
    {
        try {
            $request->merge(['id' => $id]);
            $this->validate($request, $document->getRulesID());

            $this->repository->delete($id);

            return $this->respondUpdatedResource();
        } catch(\PDOException $exception) { //db is offline

            $this->setStatusCode(503);
            return $this->respondWithErrors($exception->getMessage());
        } catch (ValidationException $e) { //object validation is failed

            return $this->respondValidationError($e->errors());
        } catch (\Exception $exception) { //error on mysql

            $this->setStatusCode(400);
            return $this->respondWithErrors($exception->getMessage());
        }
    }
}
