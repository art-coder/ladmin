<?php

namespace Artcoder\Ladmin\Repositories;

use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository as Repository;

abstract class BaseRepository extends Repository
{

    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    abstract public function model();

    public function fill($attr, $extData = [])
    {
        if ($extData) {
            $attr = array_merge($attr, $extData);
        }
        return $this->model->fill($attr);
    }

    public function store($request, $id = 0, $extData = [])
    {
        $attr = $this->fill($request->all(), $extData)->toArray();
        if ($id) {
            return $this->update($attr, $id);
        } else {
            return $this->create($attr);
        }
    }

    public function pagination($limit = 10, $columns = ['*'], $method = "paginate")
    {
        $this->applyScope();
        return $this->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate($limit, $columns, $method);
    }

    public function search($keywords, $fields, $limit = 10, $columns = ['*'], $method = "paginate")
    {
        $this->applyScope();
        if (is_string($fields)) {
            $fields = explode(",", trim($fields));
        }
        if (count($fields) == 1) {
            $first = array_shift($fields);
            $this->scopeQuery(function ($query) use ($keywords, $first) {
                return $query->where(trim($first), 'like', '%' . $keywords . '%');
            });
            $this->applyScope();
        } else {
            foreach ($fields as $field) {
                $this->scopeQuery(function ($query) use ($keywords, $field) {
                    return $query->orWhere(trim($field), 'like', '%' . $keywords . '%');
                });
                $this->applyScope();
            }
        }
        return $this->scopeQuery(function ($query) {
            return $query->orderBy('id', 'desc');
        })->paginate($limit, $columns, $method);
    }

    public function updateAll($attr, $where)
    {
        return $this->model->where($where)->update($attr);
    }

    public function incrementById($id, $field, $num = 1)
    {
        return $this->model->where('id', $id)->increment($field, $num);
    }

    public function decrementById($id, $field, $num = 1)
    {
        return $this->model->where('id', $id)->decrement($field, $num);
    }

    public function incrementByCondition(array $condition, $field, $num = 1)
    {
        return $this->model->where($condition)->increment($field, $num);
    }

    public function decrementByCondition(array $condition, $field, $num = 1)
    {
        return $this->model->where($condition)->decrement($field, $num);
    }

    public function updateByCondition(array $data, array $condition)
    {
        return $this->model->where($condition)->update($data);
    }
}
