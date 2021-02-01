<?php

namespace App\Repositories;

use App\Interfaces\Repositories\BaseInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseInterface
{
    // Protected context items
    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param int input
     * @return mixed
     */
    public function find($input)
    {
        return $this->model->find($input);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @param Model $object
     * @return mixed
     */
    public function update(array $attributes, Model $object)
    {
        $object->update($attributes);

        if ($object)
            return $object;
        else
            return null;
    }

    /**
     * @param Model $object
     * @return mixed
     */
    public function delete(Model $object)
    {
        return $object->delete();
    }

    /**
     * @param Model $object
     * @return mixed
     */
    public function restore(Model $object)
    {
        $object->restore();

        if ($object)
            return $object;
        else
            return null;
    }

    /**
     * @param Model $object
     * @return mixed
     */
    public function forceDelete(Model $object)
    {
        return $object->forceDelete();
    }

    /**
     * @param Int $id
     * @return object
     */
    public function findOrFail(Int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param Array $retriever
     * @param Array $attributes
     * @return object
     */
    public function firstOrCreate(array $retriever, array $attributes = null)
    {
        if ($attributes)
            return $this->model->firstOrCreate($retriever, $attributes);
        else
            return $this->model->firstOrCreate($retriever);
    }

    /**
     * @param Array $retriever
     * @param Array $attributes
     * @return object
     */
    public function firstOrNew(array $retriever, array $attributes)
    {
        return $this->model->firstOrNew($retriever, $attributes);
    }

    /**
     * @param Array $retriever
     * @param Array $attributes
     * @return object
     */
    public function updateOrCreate(array $retriever, array $attributes)
    {
        return $this->model->updateOrCreate($retriever, $attributes);
    }

    /**
     * @return Object
     */
    public function first()
    {
        return $this->model->first();
    }
}
