<?php declare(strict_types=1);

namespace App\Models\Interfaces;

/**
 * Interface TrackActionInterface
 * @package App\Models\Interfaces
 */
interface TrackActionInterface
{
    public function incrementTime(): void;
}
