<?php

return array(
    'module' => 'lroute',
    'name' => '路由规则',
    'introduce' => '自定义路由规则，当前版本支持thinkphp6.0.*版本。',
    'author' => 'deatil',
    'authorsite' => 'http://github.com/deatil',
    'authoremail' => 'deatil@github.com',
    'version' => '2.0.6',
    'adaptation' => '2.3.27',
    
    'path' => __DIR__,
    'need_module' => [],
    'setting' => [],
    
    // 事件
    'event' => [
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
);
