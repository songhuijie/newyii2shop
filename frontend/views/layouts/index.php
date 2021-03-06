<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

\frontend\assets\IndexAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<!--头部-->
<!--头部-->
<!--头部-->
<div class="topnav">
    <div class="topnav_bd w1210 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <?php
                if(Yii::$app->user->isGuest){
                    echo ' <li>'.'您好，欢迎来到京西！'.Html::a('登录',['member/login']).'||'.Html::a('免费注册',['member/register']).'</li>';
                }else{
                    echo " <li>您好，欢迎来到京西！<span>当前用户是:</span>";
                    echo \Yii::$app->user->identity->username;
                    echo '&nbsp;&nbsp;'.Html::a('注销',['member/logout'],['style'=>'color:red']);
                    echo '</li>';
                }
                ?>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 头部 start -->
<div class="header w1210 bc mt15">
    <!--头部结束-->
    <!--头部结束-->
    <!--头部结束-->
    <!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
    <div class="logo w1210">
        <h1 class="fl"><?=Html::img(\Yii::getAlias('@web/images/logo.png'))?></h1>
        <!-- 头部搜索 start -->
        <?=\frontend\widgets\SearchWidgets::widget()?>
        <!-- 头部搜索 end -->

        <!-- 用户中心 start-->
        <div class="user fl">
            <dl>
                <dt>
                    <em></em>
                    <a href="">用户中心</a>
                    <b></b>
                </dt>
                <dd>
                    <div class="prompt">
                        您好，请<a href="">登录</a>
                    </div>
                    <div class="uclist mt10">
                        <ul class="list1 fl">
                            <li><a href="">用户信息></a></li>
                            <li><a href="<?=\yii\helpers\Url::to(['goods/order-list'])?>">我的订单></a></li>
                            <li><a href="<?=\yii\helpers\Url::to(['address/add'])?>">收货地址></a></li>
                            <li><a href="">我的收藏></a></li>
                        </ul>

                        <ul class="fl">
                            <li><a href="">我的留言></a></li>
                            <li><a href="">我的红包></a></li>
                            <li><a href="">我的评论></a></li>
                            <li><a href="">资金管理></a></li>
                        </ul>

                    </div>
                    <div style="clear:both;"></div>
                    <div class="viewlist mt10">
                        <h3>最近浏览的商品：</h3>
                        <ul>
                            <li><a href=""><?=Html::img(\Yii::getAlias('@web/images/view_list1.jpg'))?></li>
                            <li><a href=""><?=Html::img(\Yii::getAlias('@web/images/view_list2.jpg'))?></li>
                            <li><a href=""><?=Html::img(\Yii::getAlias('@web/images/view_list3.jpg'))?></li>
                        </ul>
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 用户中心 end-->

        <!-- 购物车 start -->
        <div class="cart fl">
            <dl>
                <dt>
                    <a href="">去购物车结算</a>
                    <b></b>
                </dt>
                <dd>
                    <div class="prompt">
                        购物车中还没有商品，赶紧选购吧！
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 购物车 end -->
    </div>
    <div style="clear:both;"></div>

    <!-- 导航条部分 start -->
    <div class="nav w1210 bc mt10">
        <!--  商品分类部分 start-->
        <div class="category fl"> <!-- 非首页，需要添加cat1类 -->
            <div class="cat_hd">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                <h2>全部商品分类</h2>
                <em></em>
            </div>
            <div class="cat_bd">
                <?=\frontend\widgets\CategoryWidget::widget()?>

        <!--  商品分类部分 end-->
            </div>
        </div>
        <div class="navitems fl">
            <ul class="fl">
                <li class="current"><a href="">首页</a></li>
                <li><a href="">电脑频道</a></li>
                <li><a href="">家用电器</a></li>
                <li><a href="">品牌大全</a></li>
                <li><a href="">团购</a></li>
                <li><a href="">积分商城</a></li>
                <li><a href="">夺宝奇兵</a></li>
            </ul>
            <div class="right_corner fl"></div>
        </div>
    </div>

</div>

    <!-- 导航条部分 end -->
        <?= $content ?>
<!--底部-->
<!--底部-->
<!--底部-->
    <div style="clear:both;"></div>
    <!-- 底部版权 start -->
    <div class="footer w1210 bc mt10">
        <p class="links">
            <a href="">关于我们</a> |
            <a href="">联系我们</a> |
            <a href="">人才招聘</a> |
            <a href="">商家入驻</a> |
            <a href="">千寻网</a> |
            <a href="">奢侈品网</a> |
            <a href="">广告服务</a> |
            <a href="">移动终端</a> |
            <a href="">友情链接</a> |
            <a href="">销售联盟</a> |
            <a href="">京西论坛</a>
        </p>
        <p class="copyright">
            © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
        </p>
        <p class="auth">
            <a href=""><?=Html::img(\Yii::getAlias('@web/images/xin.png'))?>
            <a href=""><?=Html::img(\Yii::getAlias('@web/images/kexin.jpg'))?>
            <a href=""><?=Html::img(\Yii::getAlias('@web/images/police.jpg'))?>
            <a href=""><?=Html::img(\Yii::getAlias('@web/images/beian.gif'))?>
        </p>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
