<?php

return [
    'name' => 'Core',
    'info' => '系统核心，主要是后台的一些权限系统，如果需要前台显示，那么直接新建一个模块，这个模块除了路由基本不会出现Admin字样',
    'menus'       => [
        // 系统设置
        [
            'idf'     => 'system',
            'text'    => '系统设置',
            'icon'    => 'dashboard',
            'can'     => [
                'system-index',
                'system-config',
                'system-password',
            ],
            'submenu' => [
                [
                    'text'  => '系统首页',
                    'url'   => 'admin/index',
                    'icon'  => 'dashboard',
                    'can'   => 'system-index',
                    'route' => 'admin.home.index',
                ],
                [
                    'text'  => '系统配置',
                    'url'   => 'admin/setting/index',
                    'icon'  => 'cogs',
                    'can'   => 'system-config',
                    'route' => 'admin.setting.index',
                    'activeRoutes' => ['admin.setting.create'],
                ],
                [
                    'text'  => '修改密码',
                    'url'   => 'admin/setting/password',
                    'icon'  => 'key',
                    'can'   => 'system-password',
                    'route' => 'admin.setting.password',
                ],
            ],
        ],

        // 权限系统
        [
            'idf'     => 'permission',
            'text'    => '权限系统',
            'icon'    => 'users',
            'can'     => [
                'permission-list',
                'role-list',
                'user-list',
            ],
            'submenu' => [
                [
                    'text'         => '权限列表',
                    'url'          => 'admin/permission/index',
                    'icon'         => 'users',
                    'can'          => 'permission-list',
                    'route'        => 'admin.permission.index',
                    'activeRoutes' => ['admin.permission.create', 'admin.permission.edit'],
                ],
                [
                    'text'         => '角色列表',
                    'url'          => 'admin/role/index',
                    'icon'         => 'object-group',
                    'can'          => 'role-list',
                    'route'        => 'admin.role.index',
                    'activeRoutes' => ['admin.role.create', 'admin.role.edit'],
                ],
                [
                    'text'         => '用户列表',
                    'url'          => 'admin/user/index',
                    'icon'         => 'user',
                    'can'          => 'user-list',
                    'route'        => 'admin.user.index',
                    'activeRoutes' => ['admin.user.create', 'admin.user.search', 'admin.user.edit'],
                ],
            ],
        ],
    ],
    'permissions' => [
        [
            'name'  => 'system',
            'title' => '系统配置',
            'list'  => [
                ['route' => 'admin.home.index', 'can' => 'index', 'name' => '系统首页'],
                ['route' => 'admin.setting.index', 'can' => 'config', 'name' => '系统配置'],
                ['route' => 'admin.setting.create', 'can' => 'create', 'name' => '添加配置'],
                ['route' => 'admin.setting.password', 'can' => 'password', 'name' => '修改密码'],
            ],
        ],

        [
            'name'  => 'ext',
            'title' => '其他配置',
            'list'  => [
                ['route' => 'admin.upload', 'can' => 'upload', 'name' => '上传图片'],
            ],
        ],

        [
            'name'  => 'permission',
            'title' => '权限',
            'list'  => [
                ['route' => 'admin.permission.index', 'can' => 'list', 'name' => '权限列表'],
                ['route' => 'admin.permission.create', 'can' => 'create', 'name' => '创建权限'],
                ['route' => 'admin.permission.edit', 'can' => 'edit', 'name' => '修改权限'],
                ['route' => 'admin.permission.delete', 'can' => 'delete', 'name' => '删除权限'],
            ],
        ],

        [
            'name'  => 'role',
            'title' => '角色',
            'list'  => [
                ['route' => 'admin.role.index', 'can' => 'list', 'name' => '角色列表'],
                ['route' => 'admin.role.create', 'can' => 'create', 'name' => '创建角色'],
                ['route' => 'admin.role.edit', 'can' => 'edit', 'name' => '修改角色'],
                ['route' => 'admin.role.delete', 'can' => 'delete', 'name' => '删除角色'],
            ],
        ],

        [
            'name'  => 'user',
            'title' => '用户',
            'list'  => [
                ['route' => 'admin.user.index', 'can' => 'list', 'name' => '用户列表'],
                ['route' => 'admin.user.create', 'can' => 'create', 'name' => '创建用户'],
                ['route' => 'admin.user.edit', 'can' => 'edit', 'name' => '修改用户'],
                ['route' => 'admin.user.search', 'can' => 'search', 'name' => '搜索用户'],
                ['route' => 'admin.user.delete', 'can' => 'delete', 'name' => '删除用户'],
            ],
        ],
    ],

    'belongs'     => [
        'admin.permission.store' => ['permission-create', 'permission-edit'],
        'admin.role.store'       => ['role-create', 'role-edit'],
        'admin.user.store'       => ['user-create', 'user-edit'],
    ],
];
