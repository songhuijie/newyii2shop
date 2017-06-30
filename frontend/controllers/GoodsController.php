<?php
namespace frontend\controllers;
use backend\component\SphinxClient;
use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\Goodsimg;
use frontend\models\CartForm;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Cookie;

class GoodsController extends Controller{
    public $layout='goods.php';
    //首页
    public function actionIndex($id,$name){

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
    public function actionOrderList(){
        if(\Yii::$app->user->isGuest){
            return $this->redirect(['member/login']);
        }
            $member_id=\Yii::$app->user->id;

            $models=Order::findAll(['member_id'=>$member_id]);
            $arr=[];
            foreach($models as  $model){
                $goods=OrderGoods::findAll(['order_id'=>$model->id]);
                foreach($goods as $good){
                    $arr[]=$good;
                }
            }

            return $this->render('order_list',['arr'=>$arr]);

    }
    public function actionOrderdel(){
        if(\Yii::$app->user->isGuest){
            return $this->redirect(['index/index']);
        }else{
            if(\Yii::$app->request->isAjax){
                $id=\Yii::$app->request->get('id');
                $order=OrderGoods::findOne(['id'=>$id]);
//                $order->order->status=0;
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                if($order->delete()){
                    return [
                        'search'=>true,
                        'msg'=>'已删除',
                    ];
                }else{
                    return [
                        'search'=>false,
                        'msg'=>'删除失败',
                    ];
                }
            }
        }
    }
    public function actionList3(){
        $this->layout='goods';
        $query=Goods::find();
        if($keyword=\Yii::$app->request->get('key')){
            $cl = new SphinxClient();
            $cl->SetServer ( '127.0.0.1', 9312);
            $cl->SetConnectTimeout ( 10 );
            $cl->SetArrayResult ( true );
            $cl->SetMatchMode ( SPH_MATCH_EXTENDED2);
            $cl->SetLimits(0, 1000);
            $res = $cl->Query($keyword, 'goods');
            if(!isset($res['matches'])){
                $query->where(['id'=>0]);
            }else{
                $ids=ArrayHelper::map($res['matches'],'id','id');
                $query->where(['in','id',$ids]);
            }
        }

        $models=$query->all();

        $keywords = array_keys($res['words']);
        $options = array(
            'before_match' => '<span style="color:red;">',
            'after_match' => '</span>',
            'chunk_separator' => '...',
            'limit' => 80, //如果内容超过80个字符，就使用...隐藏多余的的内容
        );
//关键字高亮
//        var_dump($models);exit;
        foreach ($models as $index => $item) {
            $name = $cl->BuildExcerpts([$item->name], 'goods', implode(',', $keywords), $options); //使用的索引不能写*，关键字可以使用空格、逗号等符号做分隔，放心，sphinx很智能，会给你拆分的
            $models[$index]->name = $name[0];
        }
//var_dump($models);exit;
        return $this->render('list2',['models'=>$models]);
    }

}