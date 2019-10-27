<?php

namespace App\Services\Uptime;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\TrackActionRepositoryInterface;
use App\Services\Uptime\Interfaces\UptimeServiceInterface;

/**
 * Class UptimeService
 * @package App\Repositories\Interfaces
 */
class UptimeService implements UptimeServiceInterface
{
    /**
     * @var TrackActionRepositoryInterface
     */
    private $repository;

    /**
     * UptimeService constructor.
     *
     * @param TrackActionRepositoryInterface $repository
     */
    public function __construct(TrackActionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 'action',
    'route',
    'description',
    'times',
     */

    /**
     * @param Request $request
     * @param string  $action
     *
     * @return mixed|void
     */
    public function track(Request $request, string $action)
    {
        $trackAction = $this->repository
                            ->getOneBy(["route" => $request->getPathInfo()]);

        if ($trackAction->isEmpty()) {
            $this->repository->create([
                "action"=> $action,
                "times"=> 1,
                "route" => $request->getPathInfo()]);
            return ;
        }

        $track = $trackAction->first();

        $track->incrementTime();
        $track->update();
    }

    /**
     * @return array
     */
    public function getServerInformation(): array
    {
        $data[] = [
            "uptime" => $this->getUptimeInfo()
        ];

        $report = $this->repository->allBy([],100);

        if ($report->isEmpty()) {
            return $data;
        }

        foreach ($report as $info)
        {
            $data[] = $info->getFullDetails();
        }

        return $data;
    }

    /**
     * @return string
     */
    private function getUptimeInfo()
    {
        $ut    = strtok(exec("cat /proc/uptime"), ".");
        $days  = sprintf("%2d", ($ut / (3600 * 24)));
        $hours = sprintf("%2d", (($ut % (3600 * 24)) / 3600));
        $mins  = sprintf("%2d", ($ut % (3600 * 24) % 3600) / 60);
        $secs  = sprintf("%2d", ($ut % (3600 * 24) % 3600) % 60);

        return "Days $days, Hours $hours, Min $mins, Sec $secs";
    }
}
