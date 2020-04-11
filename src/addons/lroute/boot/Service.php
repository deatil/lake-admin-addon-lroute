<?php

namespace app\lroute\boot;

use think\Service as BaseService;

/**
 * 注册服务
 *
 * @create 2020-4-10
 * @author deatil
 */
class Service extends BaseService
{
    public function boot()
    {
        $this->app->event->listen('lake_admin_modules', function () {
            $info_file = dirname(__DIR__)
                . DIRECTORY_SEPARATOR . 'info.php';
            if (file_exists($info_file)) {
                $info = include $info_file;
            } else {
                $info = [];
            }
            
            return $info;
        });
    }
    
}
