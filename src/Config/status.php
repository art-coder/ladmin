<?php

/**
 * active 表示活跃，比如订单，待支付也属于活跃状态 是一个数组
 * inactive 表示不活跃，比如会存在删除、待审核等等 是一个数组
 * enabled 表示启用状态，唯一，比如开启、订单完成等等，只是一个状态
 * setActive 等同于 setEnabled，由于历史原因，只有setActive而没有setEnabled
 * setInactive 表示设置成最坏状态，比如删除、冻结等等
 */

return [
    'null'  => ['label' => '未知属性', 'value' => -1],
    'usual' => [
        'list'        => [
            ['value'  => 0, 'label' => '开启', 'class' => 'success'],
            ['value'  => 1, 'label' => '冻结', 'class' => 'danger'],
        ],
        'active'      => [0],
        'setActive'   => 0,
        'enabled'     => 0,
        'inactive'    => [1],
        'setInactive' => 1,
    ],
    'user'  => [
        'list'        => [
            ['value'  => 0, 'label' => '开启', 'class' => 'success'],
            ['value'  => 1, 'label' => '未验证', 'class' => 'info'],
            ['value'  => 2, 'label' => '冻结', 'class' => 'danger'],
        ],
        'active'      => [0],
        'setActive'   => 0,
        'enabled'     => 0,
        'inactive'    => [1, 2],
        'setInactive' => 2,
    ],
    'commodity' => [
        'list'        => [
            ['value'  => 0, 'label' => '上架', 'class' => 'success'],
            ['value'  => 1, 'label' => '待审核', 'class' => 'info'],
            ['value'  => 2, 'label' => '下架', 'class' => 'danger'],
        ],
        'active'      => [0],
        'setActive'   => 0,
        'enabled'     => 0,
        'inactive'    => [1, 2],
        'setInactive' => 2,
    ],
    'order' => [
        'list'        => [
            ['value'  => 0, 'label' => '已完成', 'class' => 'success'],
            ['value'  => 1, 'label' => '已删除', 'class' => 'danger'],
            ['value'  => 2, 'label' => '待付款', 'class' => 'info'],
            ['value'  => 3, 'label' => '待发货', 'class' => 'info'],
            ['value'  => 4, 'label' => '待收货', 'class' => 'info'],
            ['value'  => 5, 'label' => '待评价', 'class' => 'info'],
        ],
        'active'      => [0, 2, 3, 4, 5],
        'setActive'   => 0,
        'enabled'     => 0,
        'inactive'    => [2, 3, 4, 5],
        'setInactive' => 1,
    ],
];
