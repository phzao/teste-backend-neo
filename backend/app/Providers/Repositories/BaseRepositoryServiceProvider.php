<?php declare(strict_types=1);

namespace App\Providers\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\DocumentRepositoryInterface;
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
    }
}
