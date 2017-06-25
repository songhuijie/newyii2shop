<?php
namespace backend\widgets;
use backend\models\Menu;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Widget;

class MenuWidget extends Widget{
    public function init()
    {
        parent::init();
    }
    public function run()
    {
        NavBar::begin([
            'brandLabel' => '我的首页',
            'brandUrl' => \Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        /*$menuItems = [
            ['label' => '商品分类', 'items'=>[
                ['label' => '商品首页', 'url' => ['/act/index']],
                ['label' => '商品添加', 'url' => ['/act/add']],
            ]],
            ['label' => '品牌分类', 'items'=>[
                ['label' => '品牌首页', 'url' => ['/brand/index']],
                ['label' => '品牌添加', 'url' => ['/brand/add']],
            ]],
            ['label' => '文章分类', 'items'=>[
                ['label' => '文章分类首页', 'url' => ['/acticle/index']],
                ['label' => '文章分类添加', 'url' => ['/acticle/add']],
            ]],
            ['label' => '产品分类', 'items'=>[
                ['label' => '产品首页', 'url' => ['/goods/index']],
                ['label' => '产品添加', 'url' => ['/goods/add']],
            ]],
            ['label' => '用户', 'items'=>[
                ['label' => '用户注册', 'url' => ['/user/add']],
                ['label' => '用户首页', 'url' => ['/user/index']],
            ]],
            ['label' => '权限管理', 'items'=>[
                ['label' => '添加权限', 'url' => ['/rbac/add-permission']],
                ['label' => '权限管理', 'url' => ['/rbac/permission-index']],
                ['label' => '添加角色', 'url' => ['/rbac/add-role']],
                ['label' => '角色管理', 'url' => ['/rbac/role-index']],
            ]],
        ];*/
        if (\Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '登录', 'url' => \Yii::$app->user->loginUrl];
        } else {
            /*$menuItems[] = '<li>'. Html::beginForm(['/user/logout'], 'post')
                . Html::submitButton(
                    '注销 (' . \Yii::$app->user->identity->username . '))',
                    ['class' => 'btn btn-link logout']
                ).\yii\bootstrap\Html::a('修改密码',['user/password','id'=>\Yii::$app->user->identity->id],['class'=>'label label-default'])
                . Html::endForm()
                . '</li>';*/
            $menuItems[]= ['label' => '注销('. \Yii::$app->user->identity->username.')', 'url' => ['/user/logout']];
            /*$menuItems[]= ['label' => '用户管理', 'items' => [
                ['label' => '添加权限', 'url' => ['/rbac/add-permission']],
            ]];*/
            //找出menu表 parent_id 为0的所有顶级分类
            $menus=Menu::findAll(['parent_id'=>0]);
//            var_dump($menus);exit;
            $menuss=[];
            //循环取出所有的数据
            foreach ($menus as $menu){
                //将顶级内类遍历装到定义的数组里面
                $menuss=['label' => $menu->label, 'items'=>[]];
                //因为活动记录设置了一对多关系 所有我们可以使用表数据有对应parent_id 的对应数据 然后取出他放到2级菜单中即可
                    foreach($menu->allchildren as $child){
                        //如果当前角色没有该路由权限 我们就不给他展示2级菜单 下面这句判断该用户的路由权限的
                        if(\Yii::$app->user->can($child->url)){
                        $menuss['items'][]=['label' => $child->label, 'url' => [$child->url]];
                    }
                }
                //判断如果顶级菜单对应的2级菜单有数据 则把顶级级菜单放到一个数组中 如果没有则不显示顶级菜单
                if(!empty($menuss['items'])){
                    $menuItems[]=$menuss;
                }

            }

        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
    }
}