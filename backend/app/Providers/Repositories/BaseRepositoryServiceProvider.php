<?php declare(strict_types=1);

namespace App\Providers\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\DocumentRepositoryInterface;
use App\Repositories\Interfaces\TrackActionRepositoryInterface;
use App\Repositories\TrackActionRepository;
use App\Services\Uptime\Interfaces\UptimeServiceInterface;
use App\Services\Uptime\UptimeService;
use Illuminate\Support\ServiceProvider;

/**
 * Class BaseRepositoryServiceProvider
 * @package App\AppProviders
 */
class BaseRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            BaseRepositoryInterface::class,
            BaseRepository::class
        );
        $this->app->bind(
            DocumentRepositoryInterface::class,
            DocumentRepository::class
        );
        $this->app->bind(
            TrackActionRepositoryInterface::class,
            TrackActionRepository::class
        );
        $this->app->bind(
            UptimeServiceInterface::class,
            UptimeService::class
        );
    }
}
