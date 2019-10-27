<?php declare(strict_types=1);

namespace App\Models\Interfaces;

/**
 * Interface ModelInterface
 * @package App\Models
 */
interface DocumentInterface extends ModelInterface
{
    /**
     * @return array
     */
    public function getCPFRule(): array;

    /**
     * @return array
     */
    public function getCNPJRule(): array;


    public function setBlacklistStatus(): void;

    public function unsetBlacklistStatus(): void;
}
