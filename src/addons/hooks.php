<?php

/**
 * lake-route 添加模块配置信息
 *
 * @create 2019-11-10
 * @author deatil
 */

app()->hook->add('lake_admin_modules', function () {
    $info_file = rtrim(__DIR__, DIRECTORY_SEPARATOR) 
        . DIRECTORY_SEPARATOR . 'lroute'
        . DIRECTORY_SEPARATOR . 'info.php';
    if (file_exists($info_file)) {
        $info = include $info_file;
    } else {
        $info = [];
    }
    
    return $info;
});

