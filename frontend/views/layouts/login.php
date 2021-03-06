<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

\frontend\assets\LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<body>
<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <?php
                if(Yii::$app->user->isGuest){
                    echo ' <li>您好，欢迎来到京西！[<a href="login.html">登录</a>] [<a href="register.html">免费注册</a>] </li>';
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

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><?=\yii\helpers\Html::img(\Yii::getAlias('@web/images/logo.png'))?></a></h2>
    </div>
</div>
<!-- 页面头部 end -->

<!-- 登录主体部分start -->
<?=$content?>
<!-- 登录主体部分end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
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
        <a href=""> <?=\yii\helpers\Html::img(\Yii::getAlias('@web/images/xin.png'))?></a>
        <a href=""> <?=\yii\helpers\Html::img(\Yii::getAlias('@web/images/kexin.jpg'))?></a>
        <a href=""> <?=\yii\helpers\Html::img(\Yii::getAlias('@web/images/police.jpg'))?></a>
        <a href=""> <?=\yii\helpers\Html::img(\Yii::getAlias('@web/images/beian.gif'))?></a>
    </p>
</div>
<!-- 底部版权 end -->
<!--<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>-->
<!--<script type="text/javascript">
    function bindPhoneNum(){
        //启用输入框
        $('#captcha').prop('disabled',false);

        var time=30;
        var interval = setInterval(function(){
            time--;
            if(time<=0){
                clearInterval(interval);
                var html = '获取验证码';
                $('#get_captcha').prop('disabled',false);
            } else{
                var html = time + ' 秒后再次获取';
                $('#get_captcha').prop('disabled',true);
            }

            $('#get_captcha').val(html);
        },1000);
    }
</script>-->
</body>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
