<?php

return [

    'permissionList'    => [
        'type'          => 'danger',
        'name'          => '权限列表警告说明',
        'title'         => '警告',
        'can'           => 'permission-list',
        'items'         => [
            '<kbd>权限列表</kbd> 的 <code>增加</code> <code>删除</code> <code>修改</code> 需要对程序有了解，权限列表是和程序有关联的，因此不要轻易对权限列表进行修改！胡乱修改会导致程序出错！！！！',
        ],
    ],

    'permissionForm'    => [
        'type'          => 'danger',
        'name'          => '权限添加/修改警告说明',
        'title'         => '警告',
        'can'           => 'permission-store',
        'items'         => [
            '权限列表的增加删除修改需要对程序有了解，权限列表是和程序有关联的，因此不要轻易对权限列表进行修改！胡乱修改会导致程序出错！！！！',
        ],
    ],

    'roleForm'          => [
        'type'          => 'danger',
        'name'          => '角色添加/修改警告说明',
        'title'         => '警告',
        'can'           => 'role-store',
        'items'         => [
            '<kbd>系统首页</kbd>权限必须加上，不然相应用户进不到后台首页',
            '如果要拥有某个分组权限，那么分组权限的<kbd>xx列表</kbd>权限必须加上，比如你要给这个角色加上<kbd>用户相关权限</kbd>，那么至少需要先加上<kbd>用户列表权限</kbd>',
        ],
    ],

    'settingForm'       => [
        'type'          => 'danger',
        'name'          => '系统配置',
        'title'         => '警告',
        'can'           => 'system-config',
        'items'         => [
            '配置的添加需要在代码上体现，因此需要对代码有一定的了解，基本的配置已经在配置列表中体现了，如果不是程序员，请不要在此添加配置选项',
        ],
    ],

    'userList'          => [
        'type'          => 'primary',
        'name'          => '用户删除警告说明',
        'title'         => '提示',
        'can'           => 'user-delete',
        'items'         => [
            '如果需要删除用户，可以考虑进行用户编辑，把用户置为冻结状态，这样用户也不能进行其他操作，同样达到效果，而不是直接删除导致用户数据丢失！',
        ],
    ],

];
