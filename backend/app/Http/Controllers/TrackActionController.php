<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Document;
use App\Services\Uptime\Interfaces\UptimeServiceInterface;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\DocumentRepositoryInterface;
use Illuminate\Validation\ValidationException;

/**
 * Class TrackActionController
 * @package App\Http\Controllers
 */
class TrackActionController extends Controller
{
    /**
     * @var UptimeServiceInterface
     */
    private $uptimeService;

    /**
     * DocumentController constructor.
     *
     * @param UptimeServiceInterface $uptimeService
     */
    public function __construct(UptimeServiceInterface $uptimeService)
    {
        $this->uptimeService = $uptimeService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {

            $data = $this->uptimeService->getServerInformation();

            return $this->respond($data);
        } catch(\PDOException $exception) { //db is offline

            $this->setStatusCode(503);
            return $this->respondWithErrors($exception->getMessage());
        } catch (\Exception $exception) { //error on mysql

            $this->setStatusCode(400);
            return $this->respondWithErrors($exception->getMessage());
        }
    }
}
