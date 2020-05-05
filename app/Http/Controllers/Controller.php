<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ControllerFactory;
use App\User;
use App\Values\SearchType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $model;

    /**
     * Find method grabs model type and query by id.
     * @param  int   $id
     * @param  int|null $take filter by take method
     * @return ?Model $result
     */
    public function find(int $id, ?int $take = null) : ?Model
    {
        $modelType = $this->getModelType();

        if (!$modelType) {
            throw new \Exception('Model Type Found');
        }

        $result = $modelType::find($id);

        if ($take) {
            $result = $modelType::where('id', $id)->take($take)->get();
        }
        
        if (!$result) {
            return null;
        }

        return $result;
    }

    /**
     * return all results in model
     * @return  Collection $result
     */
    public function all() : ?Collection
    {
        $result = $this->getModelType()::all();

        if (count($result) < 1) {
            return null;
        }

        return $result;
    }

    /**
     * Grabs Model type for the given model
     * @return Model $modelType
     */
    public function getModelType() : Model
    {
        return app(ControllerFactory::class)->make($this->model);
    }

    /**
     * Just gets random User ID for now
     * @return instance USER
     */
    public function getUserID() : int
    {
        return User::inRandomOrder()->first()->id;
    }
}
