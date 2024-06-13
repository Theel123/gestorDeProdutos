<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class BaseService
{
    public function delete($idM, Model $model): bool|int
    {
        return $model::destroy($idM);
    }

    public function getById($idM, Model $model): Model
    {
        return $model::where('id', $idM)->firstOrFail();
    }

    public function getAll(Model $model = null, $paginate = null)
    {
        if (isset($paginate)) {
            return Model::paginate(5);
        }

        return $model->all();
    }

    public function create(Model $model): bool|null
    {
        return $model->save();
    }
}
