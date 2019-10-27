<?php

namespace App\Models;

use App\Models\Interfaces\TrackActionInterface;

/**
 * Class TrackAction
 * @package App\Models
 */
class TrackAction extends ModelBase implements TrackActionInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'action',
        'route',
        'times',
    ];

    /**
     * @return array
     */
    public function getFullDetails(): array
    {
        return [
            "action"      => $this->action,
            "route"       => $this->route,
            "times"       => $this->times
        ];
    }

    public function incrementTime(): void
    {
        $this->times++;
    }
}