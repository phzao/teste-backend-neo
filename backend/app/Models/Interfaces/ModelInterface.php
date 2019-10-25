<?php declare(strict_types=1);

namespace App\Models\Interfaces;

/**
 * Interface ModelInterface
 * @package App\Models
 */
interface ModelInterface 
{
    /**
     * @param null $id
     *
     * @return array
     */
    public function rules($id = null): array;

    /**
     * @return array
     */
    public function getFullDetails(): array;

    /**
     * @return array
     */
    public function getRulesID(): array;

    /**
     * @param string $column
     * @param string $format
     *
     * @return string
     */
    public function getDateTimeStringFrom(string $column, $format = "Y-m-d H:i:s"): string;

    /**
     * @param array $data
     *
     * @return array
     */
    public function getSearchParams(array $data): array;
}
