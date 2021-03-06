<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/9
 * Time: 18:32
 */

namespace app\home\controller;


class Info extends Base
{
    public function index()
    {

        $id = input('id');

        $user = model('user')->getUserByID($id);

        if (!$user) {
            $this->redirect("/404");
        }

        $this->assign('user', $user);

        $list = model('solveLog')->getUserList($id);
        $this->assign('list', $list);

        $typelist = model('type')->getCountByUser($id);

        for ($j = 0; $j < count($typelist); $j++) {
                $typelist[$j]['use'] = 0;
        }
        for ($i = 0; $i < count($list); $i++) {
            for ($j = 0; $j < count($typelist); $j++) {
                if ($list[$i]['get_subject']['type_id'] == $typelist[$j]['id']) {
                    $typelist[$j]['use'] = $typelist[$j]['use'] + 1;
                }

            }

        }


        $this->assign('typelist', $typelist);

        $res = model('SolveLog')->getCountByDay($id, 15);

        $this->assign('log', $res);

        return view();
    }

    public function edit()
    {
        if (request()->isAjax()) {
            $data = input();
            $result = model('User')->saveinfo($data);
            if ($result == 1) {
                $this->success('保存成功!');
            } else {
                $this->error($result);
            }

        }

    }

}