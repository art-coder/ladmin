<?php

namespace Artcoder\Ladmin\Libraries\Support\Traits;

trait HasTreeRepository
{

    public $treeList   = [];
    public $tree       = [];
    public $treeOption = [];

    public function getTree($pid = 0, $field = 'pid')
    {
        if (isset($this->tree[$pid]) && $this->tree[$pid]) {
            return $this->tree[$pid];
        }
        $this->tree[$pid] = $this->with('children')->findWhere([$field => $pid]);
        return $this->tree[$pid];
    }

    public function getTreeWithId($id)
    {
        return $this->with('children')->find($id);
    }

    public function getTreeOption($pid = 0, $feild = 'title', $filterFeild = 'id,title', $pidFeild = 'pid')
    {
        $this->treeOption = [];
        $list = $this->getTree($pid, $pidFeild);
        $this->_treeOption($list, $feild, $filterFeild);
        return $this->treeOption;
    }

    protected function _treeOption($list, $feild, $filterFeild, $level = 0)
    {
        $filterFeildArr = explode(',', $filterFeild);
        foreach ($list as $value) {
            $data = [];
            foreach ($filterFeildArr as $filterKey) {
                $tempKey = trim($filterKey);
                if ($tempKey == $feild) {
                    $data[$feild] = '|=' . str_pad($value[$feild], $level + strlen($value[$feild]), "=", STR_PAD_LEFT);
                } else {
                    $data[$tempKey] = $value->$tempKey;
                }
            }
            array_push($this->treeOption, $data);
            if ($value['children']) {
                $level ++;
                $this->_treeOption($value['children'], $feild, $filterFeild, $level);
                $level --;
            }
        }
    }

    public function getTreeList($pid = 0, $field = 'pid')
    {
        if (isset($this->treeList[$pid]) && $this->treeList[$pid]) {
            return collect($this->treeList[$pid]);
        }
        $this->treeList[$pid] = [];
        return $this->handleTreeList($this->with('children')->findWhere([$field => $pid]), $pid);
    }

    public function handleTreeList($list, $pid)
    {
        foreach ($list as $value) {
            if (count($value->children)) {
                $this->treeList[$pid][] = $value;
                $this->handleTreeList($value->children, $pid);
            } else {
                $this->treeList[$pid][] = $value;
            }
        }
        return collect($this->treeList[$pid]);
    }
}
