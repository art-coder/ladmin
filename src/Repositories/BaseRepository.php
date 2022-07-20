<?php

namespace Artcoder\Ladmin\Repositories;

use Error;

class BaseRepository
{

    protected $builder = null;
    protected $map = [];

    public function model($model, $module = 'Admin')
    {
        return $this->apply($model, $module, 'Model');
    }

    public function apply($model, $module = 'Admin', $res = 'Repository')
    {
        $model  = ucfirst($model);
        $module = ucfirst($module);
        if ($module == 'Admin') {
            $class = '\Artcoder\Ladmin\Entities\\' . $model;
        } else {
            $class = '\Modules\\' . $module . '\\Entities\\' . $model;
        }
        if (!isset($this->map[$class])) {
            $this->map[$class] = new $class;
        }
        $this->builder = $this->map[$class];
        // $this->builder = app()->make($model);
        if ($res == 'Repository') {
            return $this;
        } else {
            return $this->builder;
        }
    }

    public function builder($model, $module = 'Admin')
    {
        return $this->apply($model, $module);
    }

    public function fill($attr, $extData = [])
    {
        if ($extData) {
            $attr = array_merge($attr, $extData);
        }
        return $this->builder->fill($attr);
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
        return $this->builder->$method($limit, $columns);
    }

    public function search($keywords, $fields, $limit = 10, $columns = ['*'], $method = "paginate")
    {
        // 需要用到作用域   https://laravelacademy.org/post/22017
        dd('search dont realize.');
        // if (is_string($fields)) {
        //     $fields = explode(",", trim($fields));
        // }
        // $model = $this->builder;
        // if (count($fields) == 1) {
        //     $first = array_shift($fields);
        //     $this->scopeQuery(function ($query) use ($keywords, $first) {
        //         return $query->where(trim($first), 'like', '%' . $keywords . '%');
        //     });
        //     $this->applyScope();
        // } else {
        //     foreach ($fields as $field) {
        //         $this->scopeQuery(function ($query) use ($keywords, $field) {
        //             return $query->orWhere(trim($field), 'like', '%' . $keywords . '%');
        //         });
        //         $this->applyScope();
        //     }
        // }
        // return $this->scopeQuery(function ($query) {
        //     return $query->orderBy('id', 'desc');
        // })->paginate($limit, $columns, $method);
    }

    public function updateAll($attr, $where)
    {
        return $this->builder->where($where)->update($attr);
    }

    public function incrementById($id, $field, $num = 1)
    {
        return $this->builder->where('id', $id)->increment($field, $num);
    }

    public function decrementById($id, $field, $num = 1)
    {
        return $this->builder->where('id', $id)->decrement($field, $num);
    }

    public function incrementByCondition(array $condition, $field, $num = 1)
    {
        return $this->builder->where($condition)->increment($field, $num);
    }

    public function decrementByCondition(array $condition, $field, $num = 1)
    {
        return $this->builder->where($condition)->decrement($field, $num);
    }

    public function updateByCondition(array $data, array $condition)
    {
        return $this->builder->where($condition)->update($data);
    }

    public function all($columns = array('*'))
    {
        return $this->builder->all($columns);
    }

    public function get($columns = array('*'))
    {
        return $this->builder->get($columns);
    }

    public function first($columns = array('*'))
    {
        return $this->builder->first($columns);
    }

    public function findByField($field, $value, $columns = ['*'])
    {
        return $this->builder->where($field, $value)->get($columns);
    }

    public function findWhere(array $where, $columns = ['*'])
    {
        return $this->builder->where($where)->get($columns);
    }

    public function findWhereIn($field, array $where, $columns = ['*'])
    {
        return $this->builder->whereIn($field, $where)->get($columns);
    }

    public function findWhereNotIn($field, array $where, $columns = ['*'])
    {
        return $this->builder->whereNotIn($field, $where)->get($columns);
    }

    public function findWhereBetween($field, array $where, $columns = ['*'])
    {
        return $this->builder->whereBetween($field, $where)->get($columns);
    }

    public function create(array $attributes)
    {
        return $this->builder->create($attributes);
    }

    public function update(array $attributes, $id)
    {
        $model = $this->builder->find($id);
        $model->fill($attributes);
        $model->save();
    }

    // public function updateOrCreate(array $attributes, array $values = []) { }

    public function deleteWhere(array $where)
    {
        $model = $this->builder->where($where)->get();
        return $model->delete();
    }

    public function __call($method, $parameters)
    {
        $methods = [
            'value', 'pluck', 'chunk', 'count', 'max', 'avg', 'exists', 'doesntExist',
            'select', 'distinct', 'where', 'orWhere', 'whereBetween', 'orWhereBetween',
            'whereNotBetween', 'orWhereNotBetween', 'whereIn', 'whereNotIn', 'orWhereIn', 'orWhereNotIn',
            'whereNull', 'whereNotNull', 'orWhereNull', 'orWhereNotNull',
            'whereDate', 'whereMonth', 'whereDay', 'whereYear', 'whereTime', 'whereColumn', 'orWhereColumn', 'whereExists',
            'orderBy', 'orderByDesc', 'groupBy', 'having', 'latest', 'oldest', 'inRandomOrder', 'reorder', 'skip', 'take',
            'insert', 'insertOrIgnore', 'insertGetId', 'delete',
            'fill', 'with', 'find', 'paginate'
        ];
        if (in_array($method, $methods)) {
            return $this->builder->$method(...$parameters);
        } else {
            return new Error('Not method in Model');
        }
    }
}
