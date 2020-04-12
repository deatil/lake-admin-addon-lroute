<?php

namespace app\lroute\service;

use think\facade\Db;
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
                if (!empty($rule['append'])) {
                    $rule['append'] = parse_fieldlist($rule['append']);
                } else {
                    $rule['append'] = [];
                }
                
                $append = $rule['append'];

                switch ($rule['type']) {
                    case "rule";
                        ThinkRoute::rule($rule['rule'], $rule['route'], $rule['method'])
                            ->pattern($rule['pattern'])
                            ->option($rule['option'])
                            ->append($append);
                        break;
                    case "resource";
                        ThinkRoute::resource($rule['rule'], $rule['route'])
                            ->pattern($rule['pattern'])
                            ->option($rule['option'])
                            ->append($append);
                        break;
                    case "controller";
                        ThinkRoute::rule($rule['rule'], $rule['route'])
                            ->pattern($rule['pattern'])
                            ->option($rule['option'])
                            ->append($append);
                        break;
                    case "domain";
                        ThinkRoute::domain($rule['domain'], $rule['rule'])
                            ->pattern($rule['pattern'])
                            ->option($rule['option'])
                            ->append($append);
                        break;
                    case "view";
                        ThinkRoute::view($rule['rule'], $rule['template'], $rule['template_vars'])
                            ->pattern($rule['pattern'])
                            ->option($rule['option'])
                            ->append($append);
                        break;
                    case "redirect";
                        ThinkRoute::redirect($rule['rule'], $rule['route'], $rule['redirect_status'])
                            ->pattern($rule['pattern'])
                            ->option($rule['option'])
                            ->append($append);
                        break;
                    case "miss";
                        ThinkRoute::miss($rule['route'], $rule['method'])
                            ->option($rule['option'])
                            ->append($append);
                        break;
                }
            }
        }
        
        return true;
    }
}
