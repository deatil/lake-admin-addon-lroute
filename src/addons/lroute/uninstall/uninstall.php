<?php

namespace app\lroute\uninstall;

use think\Db;

use app\admin\module\Module;

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
			$tablename = config('database.prefix') . 'lroute';
			Db::execute("DROP TABLE IF EXISTS `{$tablename}`;");
        }

        return true;
    }

}
