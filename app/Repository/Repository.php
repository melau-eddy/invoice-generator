<?php
declare(strict_types=1);

namespace App\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;

/**
 * Class Repository
 *
 * @package App\Repository
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * @var Builder
     */
    protected $model;

    /**
     * Repository constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->model = $this->makeModel($app);
    }

    /**
     * Get model name with namespace
     *
     * @return String
     */
    abstract function getModel();

    /**
     * Get model
     *
     * @param $app
     *
     * @return mixed
     */
    protected function makeModel($app)
    {
        return $app->make($this->getModel());
    }

    /**
     * Get all resources
     *
     * @param array $columns
     *
     * @return Collection
     */
    public function all($columns = array('*')): Collection
    {
        return $this->model->all($columns);
    }

    /**
     * Store newly created resource
     *
     * @param array $data
     *
     * @return Model
     */
    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update specific resource.
     *
     * @param array $data
     * @param       $id
     *
     * @return bool
     */
    public function update($id, array $data): bool
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * Delete specific resource
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id): int
    {
        return $this->model->destroy($id);
    }

    /**
     * Delete multiple resource
     *
     * @param $items
     *
     * @return int
     */
    public function deleteMany($items): int
    {
        return $this->model->destroy($items);
    }

    /**
     * Find specific resource
     *
     * @param          $id
     * @param string[] $columns
     *
     * @return Builder|Builder[]|Collection|Model|object|null
     */
    public function find($id, $columns = array('*')): object
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Find specific resource by given attribute
     *
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return Object
     */
    public function findBy($attribute, $value, $columns = array('*')): object
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * Find specific all resource by given attribute
     *
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return Object
     */
    public function findAllBy($attribute, $value, $columns = array('*')): object
    {
        return $this->model->where($attribute, '=', $value)->get($columns);
    }
}
