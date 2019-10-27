<?php

namespace App\Services\Uptime\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface UptimeServiceInterface
 * @package App\Services\Uptime\Interfaces
 */
interface UptimeServiceInterface
{
    /**
     * @param Request $request
     * @param string  $action
     *
     * @return mixed
     */
    public function track(Request $request, string $action);

    /**
     * @return array
     */
    public function getServerInformation():array;
}
