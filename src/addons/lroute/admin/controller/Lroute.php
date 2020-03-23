<?php

namespace app\admin\controller;

use think\Db;
use think\facade\Cache;

use app\admin\module\Module as ModuleService;

/**
 * 规则
 *
 * @create 2019-11-9
 * @author deatil
 */
class Lroute extends LrouteBase 
{

    /**
     * 列表
     *
     * @create 2019-11-9
     * @author deatil
     */
    public function index() 
    {
        if ($this->request->isAjax()) {
            $limit = $this->request->param('limit/d', 20);
            $page = $this->request->param('page/d', 1);
            $map = $this->buildparams();
            
            $where = [];
            $module = $this->request->param('module/s');
            if (!empty($module)) {
                $where[] = ['module', 'like', '%'.$module.'%'];
            }
            $name = $this->request->param('name/s');
            if (!empty($name)) {
                $where[] = ['name', 'like', '%'.$name.'%'];
            }
            
            $order = "id DESC";
            $data = Db::name('lroute')
                ->where($map)
                ->where($where)
                ->order($order)
                ->page($page, $limit)
                ->select();
            $total = Db::name('lroute')
                ->where($map)
                ->count();

            $result = [
                "code" => 0, 
                "count" => $total, 
                "data" => $data,
            ];
            return json($result);
        } else {            
            return $this->fetch();
        }
    }

    /**
     * 添加
     *
     * @create 2019-11-9
     * @author deatil
     */
    public function add() 
    {
        if (request()->isPost()) {
            $data = request()->post();
            $validate = $this->validate($data, 'lroute/Route');
            if (true !== $validate) {
                return $this->error($validate);
            }
            
            $data = array_merge($data, [
                'add_time' => time(),
                'add_ip' => request()->ip(),
            ]);
            $result = Db::name('lroute')
                ->insert($data);
            if (false === $result) {
                return $this->error(Db::name('lroute')->getError());
            }
            
            return $this->success('添加成功！', url('admin/lroute/index'));
        } else {
            // 模块列表
            $modules = (new ModuleService())->getAll();

            $this->assign([
                'modules' => $modules,
            ]);
            
            return $this->fetch();
        }
    }

    /**
     * 编辑
     *
     * @create 2019-11-9
     * @author deatil
     */
    public function edit() 
    {
        if (request()->isPost()) {
            $data = request()->post();
            
            $validate = $this->validate($data, 'lroute/Route');
            if (true !== $validate) {
                return $this->error($validate);
            }
            
            $id = request()->post('id');
            if (empty($id)) {
                return $this->error('ID错误');
            }
            
            $info = Db::name('lroute')->where([
                'id' => $id,
            ])->find();
            if (empty($info)) {
                return $this->error('规则不存在');
            }
            
            switch ($data['type']) {
                case "rule";
                    if (empty($data['rule'])) {
                        return $this->error('路由规则不能为空');
                    }
                    if (empty($data['route'])) {
                        return $this->error('路由地址不能为空');
                    }
                    if (empty($data['method'])) {
                        return $this->error('请求类型不能为空');
                    }

                    break;
                case "resource";
                case "controller";
                    if (empty($data['rule'])) {
                        return $this->error('路由规则不能为空');
                    }
                    if (empty($data['route'])) {
                        return $this->error('路由地址不能为空');
                    }

                    break;
                case "domain";
                    if (empty($data['domain'])) {
                        return $this->error('子域名不能为空');
                    }
                    if (empty($data['rule'])) {
                        return $this->error('路由规则不能为空');
                    }

                    break;
                case "view";
                    if (empty($data['rule'])) {
                        return $this->error('路由规则不能为空');
                    }
                    if (empty($data['template'])) {
                        return $this->error('路由模板地址不能为空');
                    }

                    break;
                case "redirect";
                    if (empty($data['rule'])) {
                        return $this->error('路由规则不能为空');
                    }
                    if (empty($data['route'])) {
                        return $this->error('路由地址不能为空');
                    }
                    if (empty($data['redirect_status'])) {
                        return $this->error('跳转状态码不能为空');
                    }

                    break;
                case "miss";
                    if (empty($data['route'])) {
                        return $this->error('路由地址不能为空');
                    }
                    if (empty($data['method'])) {
                        return $this->error('请求类型不能为空');
                    }

                    break;
            }
            
            $data = array_merge($data, [
                'edit_time' => time(),
                'edit_ip' => request()->ip(),
            ]);
            $result = Db::name('lroute')
                ->where([
                    'id' => $id,
                ])
                ->update($data);
            if (false === $result) {
                return $this->error(Db::name('lroute')->getError());
            }
            
            Cache::set('lake_route_rules', null);
            
            return $this->success('修改成功！', url('admin/lroute/index'));
        } else {
            $info = Db::name('lroute')->where([
                'id' => request()->param('id'),
            ])->find();
            
            // 模块列表
            $modules = (new ModuleService())->getAll();

            $this->assign([
                'modules' => $modules,
                'info' => $info,
            ]);
            return $this->fetch();
        }
    }

    /**
     * 删除
     *
     * @create 2019-11-9
     * @author deatil
     */
    public function delete($id = '') 
    {
        $form = Db::name('lroute')->where([
            'id' => $id,
        ])->find();
        if (empty($form)) {
            return $this->error('规则不存在！');
        }
        
        $result = Db::name('lroute')->where([
            'id' => $id,
        ])->delete();
        if (false === $result) {
            return $this->error('删除失败！');
        }
        
        return $this->success('删除成功！');
    }
    
    /**
     * 修改状态
     *
     * @create 2019-11-9
     * @author deatil
     */
    public function setStatus() 
    {
        $id = request()->param('id');
        $status = input('status', '0', 'trim,intval');

        if (!$id) {
            return $this->error("非法操作！");
        }

        $map['id'] = $id;
        $result = Db::name('lroute')
            ->where($map)
            ->setField('status', $status);
        if (false === $result) {
            return $this->error("设置失败！");
        }
        
        return $this->success("设置成功！");
    } 
    
}