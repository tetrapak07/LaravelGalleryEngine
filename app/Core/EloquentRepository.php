<?php namespace App\Core;

use Illuminate\Database\Eloquent\Model;
use App\Core\Exceptions\EntityNotFoundException;

/**
 * Eloquent Repository (General queries)
 * 
 * 
 * @package  Core
 * @author    Den
 */

abstract class EloquentRepository {

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct($model = null) {

        $this->model = $model;
    }

    public function getModel() {

        return $this->model;
    }

    public function setModel($model) {

        $this->model = $model;
    }

    public function getAll() {

        return $this->model->all();
    }

    public function getAllPaginated($count) {

        return $this->model->paginate($count);
    }

    public function getById($id) {

        return $this->model->find($id);
    }

    public function getByIds($ids) {

        return $this->model->whereIn('id', $ids)->get();
    }

    public function getFirstItemByOneParam($ParamName, $ParamValue) {

        return $this->model->where($ParamName, $ParamValue)->first();
    }

    public function getAllItemsByOneParamPaginated($ParamName, $ParamValue, $count) {

        return $this->model->where($ParamName, $ParamValue)->paginate($count);
    }

    public function getAllItemsByOneParam($ParamName, $ParamValue) {

        return $this->model->where($ParamName, $ParamValue)->get();
    }

    public function getAllItemsByOneParamPaginatedOrderBy($ParamName, $ParamValue, $count, $OrderParam, $OrderValue) {

        return $this->model->where($ParamName, $ParamValue)->orderBy($OrderParam, $OrderValue)->paginate($count);
    }

    public function getAllItemsPaginatedOrderBy($count, $OrderParam, $OrderValue) {

        return $this->model->orderBy($OrderParam, $OrderValue)->paginate($count)->all();
    }

    public function getAllItemsWithLimitAndOffsetOrderBy($limit, $offset, $OrderParam, $OrderValue) {
        return $this->model->take($limit)->skip($offset)->orderBy($OrderParam, $OrderValue)->get();
    }

    public function getAllItemsByIds($ids) {

        return $this->model->whereIn('id', $ids)->get();
    }

    public function listOfIds() {
        return $this->model->lists('id');
    }

    public function listOfIdsWhere($field, $value) {
        return $this->model->where($field, $value)->lists('id');
    }

    public function getAllWhere($field, $value) {
        return $this->model->where($field, $value)->get();
    }

    public function requireById($id) {

        $model = $this->getById($id);

        if (!$model) {

            throw new EntityNotFoundException;
        }
        return $model;
    }

    public function getNew($attributes = array()) {

        return $this->model->newInstance($attributes);
    }

    public function save($data) {

        if ($data instanceOf Model) {

            return $this->storeEloquentModel($data);
        } elseif (is_array($data)) {

            return $this->storeArray($data);
        }
    }

    public function delete($model) {

        return $model->delete();
    }

    public function deleteById($id) {

        return $this->model->where('id', '=', $id)->delete();
    }

    public function updateById($id, $data) {

        return $this->model->where('id', '=', $id)->update($data);
    }

    protected function storeEloquentModel($model) {

        if ($model->getDirty()) {
            $model->save();
            return $model;
        } else {
            return $model->touch();
        }
    }

    protected function storeArray($data) {

        $model = $this->getNew($data);

        return $this->storeEloquentModel($model);
    }

    public function visibleByIds($ids, $status) {
        $count = 0;
        foreach ($ids as $val) {
            $id = (int) $val;
            $res = $this->model->where('id', '=', $id)->update(['visible' => $status]);
            if ($res) {
                $count++;
            }
        }
        if ((count($ids) >= 1) && ($count >= 1)) {
            return true;
        } else {
            return false;
        }
    }

    public function delByIds($ids) {
        $count = 0;
        foreach ($ids as $val) {
            $id = (int) $val;
            $res = $this->deleteById($id);
            if ($res) {
                $count++;
            }
        }
        if ((count($ids) >= 1) && ($count >= 1)) {
            return true;
        } else {
            return false;
        }
    }

}
