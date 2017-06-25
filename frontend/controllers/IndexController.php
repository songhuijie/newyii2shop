<?php
namespace frontend\controllers;
use backend\models\GoodsCategory;
use yii\web\Controller;

class IndexController extends Controller{
    public $layout='index.php';
    public function actionIndex(){
        return $this->render('index');
    }

}