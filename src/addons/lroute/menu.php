<?php
return [
    [
        "route" => "admin/Lroute/index",
        "type" => 1,
        "is_menu" => 1,
        //名称
        "title" => "路由规则",
        //图标
        "icon" => "icon-shiyongwendang",
        //备注
        "tip" => "",
        //排序
        "listorder" => 125,
        //子菜单列表
        "child" => [
            [
                "route" => "admin/Lroute/index",
                "type" => 1,
                "is_menu" => 1,
                "title" => "路由规则",
                "icon" => "icon-shiyongwendang",
                "child" => [
                    [
                        "route" => "admin/Lroute/add",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "添加规则",
                    ],
                    [
                        "route" => "admin/Lroute/edit",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "编辑规则",
                    ],
                    [
                        "route" => "admin/Lroute/delete",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "删除规则",
                    ],
                    [
                        "route" => "admin/Lroute/setStatus",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "规则状态",
                    ],
                ],
            ],
        ],
    ],
];
