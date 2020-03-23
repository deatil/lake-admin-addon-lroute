<?php

namespace app\lroute\validate;

use think\Validate;

/**
 * 规则验证
 *
 * @create 2019-11-9
 * @author deatil
 */
class Route extends Validate 
{
    protected $rule = [
        'name'   => 'require',
    ];
    
    protected $message = [
        'name.require' => '规则名称不能为空！',
    ];
    
    protected $scene = [
        'add' => 'name',
        'edit' => 'name'
    ];
}