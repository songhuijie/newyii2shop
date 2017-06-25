<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class GoodsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/goods.css',
        'style/common.css',
        'style/bottomnav.css',
        'style/footer.css',
        'style/jqzoom.css',
        'style/list.css',
        'style/order.css',
        'style/user.css',
        'style/home.css',
    ];
    public $js = [
        'js/header.js',
        'js/index.js',
        'js/jqzoom-core.js',
        'js/list.js',
        'js/home.js',
        'js/goods.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}

