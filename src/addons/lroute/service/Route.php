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
                    $rule['domain'] = lake_parse_attr($rule['domain']);
                } else {
                    $rule['domain'] = [];
                }
                if (!empty($rule['template_vars'])) {
                    $rule['template_vars'] = json_decode($rule['template_vars'], true);
                } else {
                    $rule['template_vars'] = [];
                }
                if (!empty($rule['option'])) {
                    $rule['option'] = json_decode($rule['option'], true);
                } else {
                    $rule['option'] = [];
                }
                if (!empty($rule['pattern'])) {
                    $rule['pattern'] = json_decode($rule['pattern'], true);
                } else {
                    $rule['pattern'] = [];
                }
                if (!empty($rule['append'])) {
                    $rule['append'] = json_decode($rule['append'], true);
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
