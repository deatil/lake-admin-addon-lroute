<?php

return array(
    'module' => 'lroute',
    'name' => '路由规则',
    'introduce' => '自定义路由规则，当前版本支持thinkphp6.0.*版本。',
    'author' => 'deatil',
    'authorsite' => 'http://github.com/deatil',
    'authoremail' => 'deatil@github.com',
    'version' => '2.0.5',
    'adaptation' => '2.0.2',
    'sign' => '4d58c4c18ef962153142605f47ccbe56',
    
    // 模块地址
    'path' => __DIR__,
    
    'need_module' => [],
    
    'setting' => [],
    
    // 嵌入点
    'hooks' => [
        'InitRoute' => [
            'name' => 'RouteLoaded',
            'class' => 'app\\lroute\\behavior\\InitRoute',
            'description' => 'Lroute公用初始化嵌入点',
            'listorder' => 50,
            'status' => 1,
        ],
    ],
    
    // 菜单
    'menus' => include __DIR__ . '/menu.php',
    
    'tables' => [
        'lroute',
    ],
);
