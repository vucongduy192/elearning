<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 *
 * @package App\Repositories
 */
class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @inheritdoc
     */
    public function find(array $conditions = [])
    {
        return $this->model->where($conditions)->get();
    }

    /**
     * @inheritdoc
     */
    public function findOne(array $conditions)
    {
        return $this->model->where($conditions)->first();
    }

    /**
     * @inheritdoc
     */
    public function findById(int $id)
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * @inheritdoc
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @inheritdoc
     */
    public function update(Model $model, array $attributes = [])
    {
        return $model->update($attributes);
    }

    /**
     * @inheritdoc
     */
    public function save(Model $model)
    {
        return $model->save();
    }

    /**
     * @inheritdoc
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }
}
