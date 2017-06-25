<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
//        'light\widgets\SweetSubmitAsset',
    ];
    //因为jquery 在yii框架中是默认底部的位置 所以我们使用了这个方法将jquery的引入放到了顶部
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}
