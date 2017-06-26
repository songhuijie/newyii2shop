<?php
namespace frontend\controllers;
use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\Goodsimg;
use frontend\models\CartForm;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Cookie;

class GoodsController extends Controller{
    public $layout='goods.php';
    //首页
    public function actionIndex($id,$name){
        if(\Yii::$app->user->isGuest){
            return $this->redirect(['index/index']);
        }
        $category=GoodsCategory::findOne(['name'=>$name]);
        $goodsimg=Goodsimg::find()->asArray()->where(['goods_id'=>$id])->all();
        $goods=Goods::findOne(['id'=>$id]);
        return $this->render('content',['goods'=>$goods,'category'=>$category,'goodsimg'=>$goodsimg]);
    }
    //详情页
    public function actionList($id){
        $brands=Brand::find()->all();
        $goodscategory=GoodsCategory::findOne(['id'=>$id]);
        $category=GoodsCategory::findOne(['id'=>$id]);


        if($category->depth==1){
            $categories=GoodsCategory::find()->where(['tree'=>$category->tree,'depth'=>$category->depth+1,'parent_id'=>$category->id])->all();
            $goods=[];
            foreach($categories as $cate){
                $good=Goods::find()->where(['goods_category_id'=>$cate->id])->all();

                $goods =array_merge($goods,$good);
            }
            //返回
            return $this->render('list',['goodscategory'=>$goodscategory,'goods'=>$goods,'brands'=>$brands,'id'=>$id]);

        }elseif($category->depth==2){
            $goods=Goods::find()->where(['goods_category_id'=>$id]);
            $pagelation=new Pagination([
                'totalCount'=>$goods->count(),
                'defaultPageSize'=>8,
            ]);
            $goods=$goods->offset($pagelation->offset)->limit($pagelation->limit)->all();
            //返回

            return $this->render('list',['goodscategory'=>$goodscategory,'goods'=>$goods,'pagelation'=>$pagelation,'brands'=>$brands,'id'=>$id]);
        }



    }
    //详情页搜索
    public function actionList2($id,$brand_id){
        $brands=Brand::find()->all();
        $goods=Goods::find()->where(['goods_category_id'=>$id,'brand_id'=>$brand_id]);
        $good=Goods::findOne(['brand_id'=>$brand_id]);


        $pagelation=new Pagination([
            'totalCount'=>$goods->count(),
            'defaultPageSize'=>8,
        ]);
        $goodscategory=GoodsCategory::findOne(['id'=>$id]);
        $goods=$goods->offset($pagelation->offset)->limit($pagelation->limit)->all();
        return $this->render('list',['goodscategory'=>$goodscategory,'goods'=>$goods,'pagelation'=>$pagelation,'brands'=>$brands,'id'=>$id,'brand_id'=>$brand_id,'good'=>$good]);
    }
    public function actionOrder(){
        return $this->render('order');
    }
    public function actionUser(){
        return $this->render('user');
    }
    public function actionaAdd(){
        $cookie=new Cookie();
    }
    public function actionOrderList(){
        if(\Yii::$app->user->isGuest){
            return $this->redirect(['index/index']);
        }else{
            $member_id=\Yii::$app->user->id;
            $orders=Order::findAll(['member_id'=>$member_id]);
            $ordergoods=OrderGoods::findAll(['member_id'=>$member_id]);
            return $this->render('order_list');
        }
    }

}