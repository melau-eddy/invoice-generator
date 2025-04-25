<?php
declare(strict_types=1);
namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface RepositoryInterface
 *
 * @package App\Repository
 */
interface RepositoryInterface
{
    /**
     * Get all resources
     *
     * @param array $columns
     *
     * @return Collection
     */
    public function all($columns = array('*'));

    /**
     * Stores newly created resource
     *
     * @param array $data
     *
     * @return object
     */
    public function store(array $data);

    /**
     * Update specific resource.
     *
     * @param array $data
     * @param       $id
     *
     * @return bool
     */
    public function update($id, array $data);

    /**
     * Delete specific resource
     *
     * @param $id
     *
     * @return bool
     */
    public function delete($id);

    /**
     * Find specific resource
     *
     * @param       $id
     * @param array $columns
     *
     * @return object
     */
    public function find($id, $columns = array('*'));

    /**
     * Find specific resource by given attribute
     *
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return Object
     */
    public function findBy($attribute, $value, $columns = array('*'));
}
