<?php

namespace app\lroute\install;

use think\Db;

use app\admin\module\Module;

/**
 * 安装脚本
 *
 * @create 2019-11-9
 * @author deatil
 */
class install
{
    /**
     * 安装完回调
     * @return boolean
     */
    public function end()
    {		
		$Module = new Module();
		
		// 清除旧数据
		if (request()->param('clear') == 1) {
			$tablename = config('database.prefix') . 'lroute';
			Db::execute("DROP TABLE IF EXISTS `{$tablename}`;");
		}
		
		// 安装数据库
		$runSqlStatus = $Module->runSQL(__DIR__ . "/install.sql");
		if (!$runSqlStatus) {
			$this->error = $runSqlStatus->getError();
		}
		
        return true;
    }

}
