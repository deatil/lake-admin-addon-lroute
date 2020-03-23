<?php

namespace app\lroute\behavior;

use app\lroute\service\Route as RouteService;

/**
 * 初始化钩子信息
 *
 * @create 2019-11-10
 * @author deatil
 */
class InitRoute
{

    /**
     * 设置路由
     *
     * @create 2019-11-10
     * @author deatil
     */
    public function run($params)
    {
        (new RouteService())->setRoute();
    }

}
