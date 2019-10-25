<?php declare(strict_types=1);

namespace App\Providers\Utils;

use App\Utils\HandleErrors\ErrorMessage;
use App\Utils\HandleErrors\ErrorMessageInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class UtilsServiceProvider
 * @package App\AppProviders
 */
class UtilsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ErrorMessageInterface::class,
            ErrorMessage::class
        );
    }
}

