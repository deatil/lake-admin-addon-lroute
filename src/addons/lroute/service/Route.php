<?php

namespace app\lroute\service;

use think\Db;
use think\facade\Cache;
use think\facade\Route as ThinkRoute;

/**
 * 路由规则
 *
 * @create 2019-11-10
 * @author deatil
 */
class Route
{

    /**
     * 设置路由
     *
     * @create 2019-11-10
     * @author deatil
     */
    public function setRoute()
    {
        $rules = Cache::get('lake_route_rules');
        if (empty($rules)) {
            $rules = Db::name('lroute')
                ->field('*')
                ->where([
                    'status' => 1,
                ])
                ->order([
                    'sort' => 'ASC',
                    'id' => 'ASC',
                ])
                ->select();
            
            Cache::set('lake_route_rules', $rules);
        }
            
        if (!empty($rules)) {
            foreach ($rules as $rule) {
                if (!empty($rule['domain'])) {
                    $rule['domain'] = parse_attr($rule['domain']);
                } else {
                    $rule['domain'] = [];
                }
                if (!empty($rule['template_vars'])) {
                    $rule['template_vars'] = parse_fieldlist($rule['template_vars']);
                } else {
                    $rule['template_vars'] = [];
                }
                if (!empty($rule['option'])) {
                    $rule['option'] = parse_fieldlist($rule['option']);
                } else {
                    $rule['option'] = [];
                }
                if (!empty($rule['pattern'])) {
                    $rule['pattern'] = parse_fieldlist($rule['pattern']);
                } else {
                    $rule['pattern'] = [];
                }

                switch ($rule['type']) {
                    case "rule";
                        ThinkRoute::rule($rule['rule'], $rule['route'], $rule['method'], $rule['option'], $rule['pattern']);
                        break;
                    case "resource";
                        ThinkRoute::resource($rule['rule'], $rule['route'], $rule['option'], $rule['pattern']);
                        break;
                    case "controller";
                        ThinkRoute::controller($rule['rule'], $rule['route'], $rule['option'], $rule['pattern']);
                        break;
                    case "domain";
                        ThinkRoute::domain($rule['domain'], $rule['rule'], $rule['option'], $rule['pattern']);
                        break;
                    case "view";
                        ThinkRoute::view($rule['rule'], $rule['template'], $rule['template_vars'], $rule['option'], $rule['pattern']);
                        break;
                    case "redirect";
                        ThinkRoute::redirect($rule['rule'], $rule['route'], $rule['redirect_status'], $rule['option'], $rule['pattern']);
                        break;
                    case "miss";
                        ThinkRoute::miss($rule['route'], $rule['method'], $rule['option']);
                        break;
                }
            }
        }
        
        return true;
    }
}
