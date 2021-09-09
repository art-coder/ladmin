<?php

namespace Artcoder\Ladmin\Libraries\Support\Traits;

trait HasStatus
{

    public function getState()
    {
        $this->checkStatusType();
        if ($this->status === null) {
            return (object) config('status.null');
        }
        return (object) $this->originalList()[$this->status];
    }

    public function getStatus()
    {
        $status = $this->originalList();
        $res = [];
        foreach ($status as $key => $value) {
            $res[$key] = (object) $value;
        }
        return $res;
    }

    // 不能使用status，因为字段中有status，导致$model->status报错
    public function state($state)
    {
        return $this->where('status', $state);
    }

    // 不能在Relation中使用，如果要用，参考Mall Commodity 中的 getCurrentPriceAttribute 方法
    public function active()
    {
        $active = $this->originalActive();
        $num    = count($active);
        if ($num == 0) {
            return $this;
        } elseif ($num == 1) {
            return $this->where('status', $active[0]);
        } else {
            return $this->whereIn('status', $active);
        }
    }

    public function enabled()
    {
        $enabled = $this->originalEnabled();

        return $this->where('status', $enabled);
    }

    public function setActive($modle = null)
    {
        $this->checkStatusType();
        $state = config('status.' . $this->statusType . '.setActive');
        if ($modle) {
            return $modle->update(['status' => $state]);
        } else {
            return $this->update(['status' => $state]);
        }
    }

    public function inactive()
    {
        $inactive = $this->originalInactive();
        $num      = count($inactive);
        if ($num == 0) {
            return $this;
        } elseif ($num == 1) {
            return $this->where('status', $inactive[0]);
        } else {
            return $this->whereIn('status', $inactive);
        }
    }

    public function setInactive($modle = null)
    {
        $this->checkStatusType();
        $state = config('status.' . $this->statusType . '.setInactive');
        if ($modle) {
            return $modle->update(['status' => $state]);
        } else {
            return $this->update(['status' => $state]);
        }
    }

    protected function originalList()
    {
        $this->checkStatusType();
        return config('status.' . $this->statusType . '.list');
    }

    public function originalActive()
    {
        $this->checkStatusType();
        return config('status.' . $this->statusType . '.active');
    }

    public function originalEnabled()
    {
        $this->checkStatusType();
        return config('status.' . $this->statusType . '.enabled');
    }

    public function originalInactive()
    {
        $this->checkStatusType();
        return config('status.' . $this->statusType . '.inactive');
    }

    protected function checkStatusType()
    {
        if (!$this->statusType) {
            $this->statusType = 'usual';
        }
    }
}
