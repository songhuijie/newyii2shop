<?php
namespace frontend\controllers;
use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

class PayController extends Controller{
    public $layout='pay.php';
    public function actionCookie(){

        if(\Yii::$app->user->isGuest){
            $goods_id=\Yii::$app->request->post('goods_id');
            $amount=\Yii::$app->request->post('amount');
            $goods=Goods::findOne(['id'=>$goods_id]);
            //如果商品不存在给出一个提示
            if($goods==null){
                throw new NotFoundHttpException('商品不存在');
            }
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            if($cookie == null){
                $cart = [];
            }else{
                $cart = unserialize($cookie->value); //$cart = [2=>10];
            }
            $cookie=\Yii::$app->response->cookies;
            //上面拿到保存在cookie的数据 然后判断当前id为键 的商品存不存在于cookie中 如果存在就追加 如果不存在 就放到cookie2位数组中
            if(key_exists($goods->id,$cart)){
                $cart[$goods_id]+=$amount;
            }else{
                $cart[$goods_id]=$amount;
            }
            $cookies=new Cookie([
                    'name'=>'cart','value'=>serialize($cart)
                ]);
            $cookie->add($cookies);
        }else{
            //用户登录的时候
            //用户登录的时候
            $member_id=\Yii::$app->user->id;
            $goods_id=\Yii::$app->request->post('goods_id');
            $amount=\Yii::$app->request->post('amount');
            $cart=Cart::findOne(['goods_id'=>$goods_id,'member_id'=>$member_id]);
            if($cart){
                $cart->amount=$cart->amount+$amount;
                $cart->save();
            }else{
                $goods=Goods::findOne(['id'=>$goods_id]);
                if($goods){
                    $carts=new Cart();
                    $carts->goods_id=$goods->id;
                    $carts->amount=$amount;
                    $carts->member_id=$member_id;
                    $carts->save();
                }
            }
        }

        return $this->redirect(['pay/mycar']);
    }
    public function actionMycar(){
        if(\Yii::$app->user->isGuest){
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            if($cookie == null){
                //cookie中没有购物车数据
                $cart = [];
            }else{
                $cart = unserialize($cookie->value); //$cart = [2=>10];
            }
            $models=[];
            foreach($cart as $k=>$v){
                $goods=Goods::findOne(['id'=>$k])->attributes;
                $goods['amount']=$v;
                $models[]=$goods;
            }
        }else {

            $carts = Cart::findAll(['member_id' => \Yii::$app->user->id]);
            if(empty($carts)){
                return $this->redirect(['index/index']);
            }
            $models=[];
            foreach ($carts as $cart) {
                $goods = Goods::findOne(['id' => $cart->goods_id])->attributes;
                $goods['amount'] = $cart->amount;
                $models[] = $goods;
            }
        }
        return $this->render('flow1',['models'=>$models]);
    }
    //回显购物车商品的时候删除对应商品
    public function actionUpdate(){
        if(\Yii::$app->user->isGuest){
            //修改cookie中的
            //修改cookie中的
            $goods_id=\Yii::$app->request->post('goods_id');
            $amount=\Yii::$app->request->post('amount');
            $goods=Goods::findOne(['id'=>$goods_id]);
            if($goods==null){
                throw new NotFoundHttpException('商品不存在');
            }
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            if($cookie == null){
                $cart = [];
            }else{
                $cart = unserialize($cookie->value); //$cart = [2=>10];
            }
            if($amount!=0){
                //如果修改或者删除  判断amount的值 如果有就修改 如果等于0 则删除
                $cart[$goods_id] = $amount;
            }else{
                if(key_exists($goods['id'],$cart)) unset($cart[$goods_id]);
            }
            $cookie=\Yii::$app->response->cookies;
            //上面拿到保存在cookie的数据 然后判断当前id为键 的商品存不存在于cookie中 如果存在就追加 如果不存在 就放到cookie2位数组中
            //$array[3=>33]
            $cookies=new Cookie([
                'name'=>'cart','value'=>serialize($cart)
            ]);
            $cookie->add($cookies);
        }else{
            //修改数据库中的
            $goods_id=\Yii::$app->request->post('goods_id');
            $amount=\Yii::$app->request->post('amount');
            $member_id=\Yii::$app->user->id;
            if($amount==0){
                $cart=Cart::findOne(['goods_id'=>$goods_id,'member_id'=>$member_id]);
                $cart->delete();
            }else{
                $cart=Cart::findOne(['goods_id'=>$goods_id,'member_id'=>$member_id]);
                $cart->amount=$amount;
                $cart->save();
            }
        }

    }
//测试怎么删除cookie
    public function actionTest(){
//        $cookie=\Yii::$app->response->cookies;
//        $arr=[1=>2,2=>3];
//        $cookies=new Cookie(['name'=>'c','value'=>serialize($arr)]);
//        $cookie->add($cookies);

//        $cookie=\Yii::$app->response->cookies;
//        $c=\Yii::$app->response->cookies->get('c');
//        $cookie->remove($c);
//        var_dump(\Yii::$app->response->cookies->get('c'));
    }








//跳转到支付页面 回显信息
    public function actionInformation(){
        if(\Yii::$app->user->isGuest){
           return $this->redirect(['member/login']);
        }else{
            //订单表
            $model=new Order();
            //订单详情
            $order=new OrderGoods();
           $member_id=\Yii::$app->user->id;
           //默认地址
           $address1=Address::findOne(['member_id'=>$member_id,'status'=>1]);
           //其他地址
           $address0=Address::findOne(['member_id'=>$member_id,'status'=>0]);
            //所购买的商品
            $carts=Cart::findAll(['member_id'=>$member_id]);
            $count=Cart::find()->where(['member_id'=>$member_id])->count();
            $goods=[];
            foreach($carts as $cart){
                $good=Goods::findOne(['id'=>$cart->goods_id])->attributes;
                $good['amount']=$cart->amount;
                $goods[]=$good;
            }
//            var_dump($goods);exit;
            $zong=0;
            foreach ($goods as $good){
                $zong+=$good['shop_price']*$good['amount'];
            };
            return $this->render('flow2',['model'=>$model,'address1'=>$address1,'address0'=>$address0,'goods'=>$goods,'order'=>$order,'count'=>$count,'zong'=>$zong]);
        }

    }
    //支付成功 跳转保存order信息 和order_goods 信息
    public function actionSuccess(){
        $order=new Order();
        if(\Yii::$app->request->post()){
            $post=\Yii::$app->request->post();
            //使用了事务
            if($order->reload($post)){
                return $this->redirect(['pay/success']);
            }
        }
        return $this->render('flow3');
    }
}