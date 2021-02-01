<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Model;

interface BaseInterface
{
    /**
     * @return mixed
     */
    public function all();

    /**
     * @param int input
     * @return mixed
     */
    public function find($input);

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param array $attributes
     * @return mixed
     */
    public function update(array $attributes, Model $object);

    /**
     * @param Model $object
     * @return mixed
     */
    public function delete(Model $object);

    /**
     * @param Model $object
     * @return mixed
     */
    public function restore(Model $object);

    /**
     * @param Model $object
     * @return mixed
     */
    public function forceDelete(Model $object);

    /**
     * @param Array $retriever
     * @param Array $attributes
     * @return object
     */
    public function firstOrCreate(array $retriever, array $attributes);

    /**
     * @param Array $retriever
     * @param Array $attributes
     * @return object
     */
    public function firstOrNew(array $retriever, array $attributes);

    /**
     * @param Array $retriever
     * @param Array $attributes
     * @return object
     */
    public function updateOrCreate(array $retriever, array $attributes);

    /**
     * @return Object
     */
    public function first();
}
