<?php

namespace app\lroute;

use think\facade\Db;

use lake\admin\module\Module;

/**
 * 卸载脚本
 *
 * @create 2019-11-9
 * @author deatil
 */
class Uninstall
{

    //卸载
    public function run()
    {
        if (request()->param('clear') == 1) {
            // 删除表
            $dbPrefix = app()->db->connect()->getConfig('prefix');
            $tablename = $dbPrefix . 'lroute';
            Db::execute("DROP TABLE IF EXISTS `{$tablename}`;");
        }

        return true;
    }

}
