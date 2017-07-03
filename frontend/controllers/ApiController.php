<?php
namespace frontend\controllers;

use backend\models\Acticle;
use backend\models\ActicleCategory;
use backend\models\Goods;
use backend\models\GoodsCategory;
use EasyWeChat\Support\Log;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Login;
use frontend\models\Member;
use frontend\models\Order;
use frontend\models\OrderGoods;
use frontend\models\RetwopasswordForm;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\UploadedFile;

class ApiController extends Controller{
    //关闭跨站攻击验证
    public $enableCsrfValidation=false;
    public function init()
    {
        //将所有数组以json格式数据返回
        \Yii::$app->response->format=Response::FORMAT_JSON;
        parent::init(); // TODO: Change the autogenerated stub
    }
    //会员  会员注册
    public function actionMemberRegister(){
        $request=\Yii::$app->request;

        if($request->isPost){

            $member=new Member();
            $member->scenario=Member::SCENARIO_API_REGISTER;
            $this->action;
            $member->username=$request->post('username');
            $member->password=$request->post('password');
            $member->email=$request->post('email');
            $member->tel=$request->post('tel');
            $member->code=$request->post('code');
            $member->smsCode=$request->post('smsCode');
            if($member->validate()){
                $member->password_hash=\Yii::$app->security->generatePasswordHash( $member->password);
                $member->save(false);
                return ['success'=>true,'msg'=>'','data'=>$member->toArray()];
            }
            return ['success'=>false,'msg'=>$member->getErrors()];
        }
        return ['success'=>false,'msg'=>'非POST提交'];
    }
    //会员  会员登录
    public function actionMemberLogin(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $login=new Login();
            $username=$request->post('username');
            $password=$request->post('password');
            if($member=Member::findOne(['username'=>$username])){
                if(\Yii::$app->security->validatePassword($password,$member->password_hash)){
                    $member->last_login_time=time();
                    $member->last_login_ip=\Yii::$app->request->getUserIP();
                    $member->save();
                    //将用户信息保存到服务器上
                    \Yii::$app->user->login($member);
                    return ['success'=>true,'msg'=>'','data'=>$member->toArray()];
                }
                return ['success'=>false,'msg'=>'密码错误'];
            }
            return ['success'=>false,'msg'=>'用户名错误'];
        }
        return ['success'=>false,'msg'=>'不是post请求'];
    }
    //修改密码
    public function actionRePassword(){
        $request=\Yii::$app->request;
//        var_dump(\Yii::$app->user->isGuest);exit;
        if(\Yii::$app->user->isGuest){
            return ['success'=>false,'msg'=>'当前是游客登录'];
        }

        if($request->isPost){
            $pass=new RetwopasswordForm();

            $old_password=$request->post('old_password');
            $new_password=$request->post('new_password');
            $new2_password=$request->post('new2_password');
            $member=Member::findOne(['id'=>\Yii::$app->user->id]);
                if(\Yii::$app->security->validatePassword($old_password,$member->password_hash)){
                    if($new_password==$new2_password){
                        $member->password_hash=\Yii::$app->security->generatePasswordHash($new2_password);
                        if($member->save(false)){
                            return ['success'=>true,'msg'=>'修改成功'];
                        }

                    }
                    return ['success'=>false,'msg'=>'2次输入密码不一致'];
                }
                return ['success'=>false,'msg'=>'密码不正确'];
        }
        return ['success'=>false,'msg'=>'不是post请求'];
    }
    //获取当前用户登录信息
    public function actionUserInfo(){
        if(\Yii::$app->user->isGuest){
            return ['success'=>false,'msg'=>'当前是游客登录'];
        }
        $member=Member::findOne(['id'=>\Yii::$app->user->id])->toArray();
        return ['success'=>true,'data'=>$member];
    }
    //注销当前用户
    public function actionLogout(){
        if(\Yii::$app->user->isGuest){
            return ['success'=>false,'msg'=>'当前是游客登录'];
        }
        \Yii::$app->user->logout();
        return ['success'=>false,'msg'=>'注销成功'];
    }
    //添加地址
    public function actionAddressAdd(){
        $request=\Yii::$app->request;
        if(\Yii::$app->user->isGuest){
            return ['success'=>false,'msg'=>'当前是游客登录'];
        }
        $member_id=\Yii::$app->user->id;
        if($request->isPost){
            $address=new Address();
            $address->name=$request->post('name');
            $address->tel=$request->post('tel');
            $address->member_id=$member_id;
            $address->address=$request->post('address');
            $address->province=$request->post('province');
            $address->city=$request->post('city');
            $address->area=$request->post('area');
            if($address->validate()){
                if($address->save()){
                    return ['success'=>true,'msg'=>'保存成功'];
                }
                return ['success'=>false,'msg'=>'保存失败'];
            }
            return ['success'=>false,'msg'=>'填写地址有误,请重新填写'];
        }
        return ['success'=>false,'msg'=>'不是post请求'];
    }
    //地址列表
    public function actionAddressList(){
        if(\Yii::$app->user->isGuest){
            return ['success'=>false,'msg'=>'当前是游客登录'];
        }
        $member_id=\Yii::$app->user->id;
        $address=Address::findAll(['member_id'=>$member_id]);
        if($address){
            return ['success'=>true,'msg'=>'','data'=>$address];
        }
        return ['success'=>false,'msg'=>'该用户还没有地址'];
    }
    //删除地址
    public function actionAddressDel(){
        $request=\Yii::$app->request;
        if(\Yii::$app->user->isGuest){
            return ['success'=>false,'msg'=>'当前是游客登录'];
        }
        $member_id=\Yii::$app->user->id;
        if($request->isGet){
            if($id=$request->get('id')){
                $address=Address::findOne(['id'=>$id,'member_id'=>$member_id]);
                if($address){
                    $address->status=-1;
                    $address->save();
                    return ['success'=>true,'msg'=>'删除成功'];
                }
                return ['success'=>false,'msg'=>'不存在的数据'];
            }
            return ['success'=>false,'msg'=>'不存在的数据'];
        }
        return ['success'=>false,'msg'=>'不是post请求'];
    }
    //修改地址
    public function actionAddressEdit(){
        if(\Yii::$app->user->isGuest){
            return ['success'=>false,'msg'=>'当前是游客登录'];
        }
        $request=\Yii::$app->request;
        if($id=$request->get('id')){
            if($request->isPost){
                $member_id=\Yii::$app->user->id;
                $address=Address::findOne(['id'=>$id]);
                $address->name=$request->post('name');
                $address->tel=$request->post('tel');
                $address->member_id=$member_id;
                $address->address=$request->post('address');
                $address->province=$request->post('province');
                $address->city=$request->post('city');
                $address->area=$request->post('area');
                if($address->validate()){
                    $address->update();
                    return ['success'=>true,'msg'=>'更新成功'];
                }
                return ['success'=>false,'msg'=>'更新失败'];
            }

            $address=Address::find()->where(['id'=>$id])->asArray()->all();
                if($address){
                    return ['success'=>true,'msg'=>'','data'=>$address];
                }
            return ['success'=>false,'msg'=>'没有数据'];
        }
        return ['success'=>false,'msg'=>'数据不存在'];
    }


    //获取所有商品分类
    public function actionCategoryAll(){
        $categories=GoodsCategory::find()->asArray()->all();
        return ['success'=>true,'data'=>$categories];
    }
    //获取某分类的所有子分类
    public function actionGetChlidren(){
        if(\Yii::$app->request->isGet){
            if($category_id=\Yii::$app->request->get('category_id')){

                    $categories=GoodsCategory::findOne(['id'=>$category_id]);
                if($categories==null){
                    return ['success'=>false,'msg'=>'数据不存在'];
                }
                switch($categories->depth){
                    case 2;
                        $categories=GoodsCategory::findOne(['id'=>$category_id]);
                    break;
                    case 1;
                        $ids = ArrayHelper::map($categories->children,'id','id');
                        $categories=GoodsCategory::find()->Where(['in','id',$ids])->all();
                    break;
                    case 0;
                        $ids = ArrayHelper::map($categories->leaves()->asArray()->all(),'id','id');
                        $categories=GoodsCategory::find()->Where(['in','id',$ids])->all();
                    break;
                }
                return ['success'=>true,'data'=>$categories];
            }
            return ['success'=>false,'msg'=>'数据不存在'];
        }
        return ['success'=>false,'msg'=>'不是get方式提交'];
    }
    //获取某分类的父分类
    public function actionGetParent(){
        if(\Yii::$app->request->isGet){
            if($category_id=\Yii::$app->request->get('category_id')){
                $category=GoodsCategory::find()->where(['id'=>$category_id])->asArray()->one();
                if($category){
                    return ['success'=>true,'data'=>$category];
                }
                return ['success'=>false,'msg'=>'没有对应的数据'];
            }
            return ['success'=>false,'msg'=>'数据不存在'];
        }
        return ['success'=>false,'msg'=>'不是get方式提交'];
    }


    //获取某品牌下面的所有商品
    public function actionGetBrandByGoods(){
        if($brand_id=\Yii::$app->request->get('brand_id')){
            $goods=Goods::find()->where(['brand_id'=>$brand_id])->asArray()->all();
            if($goods){
                return ['success'=>true,'msg'=>'','data'=>$goods];
            }
            return ['success'=>false,'msg'=>'抱歉，没有此类商品'];
        }
        return ['success'=>false,'msg'=>'发送请求失败'];
    }
    //获取某分类下面的所有商品
    public function actionCategoryByGoods(){
        if($cate_id=\Yii::$app->request->get('cate_id')){
            $goods=Goods::find();
            $goodscategory=GoodsCategory::findOne(['id'=>$cate_id]);
            switch($goodscategory->depth){
                case 2;
                    $goods=Goods::find()->where(['id'=>$cate_id])->asArray()->all();
                break;
                case 1;
                    $ids=ArrayHelper::map($goodscategory->children,'id','id');
                    $goods=Goods::find()->Where(['in','goods_category_id',$ids])->asArray()->all();
                break;
                case 0;
                    $ids = ArrayHelper::map($goodscategory->leaves()->asArray()->all(),'id','id');
                    $goods=Goods::find()->Where(['in','goods_category_id',$ids])->asArray()->all();
                break;
            }
                return ['success'=>true,'msg'=>'','data'=>$goods];
        }
        return ['success'=>false,'msg'=>'发送请求失败'];
    }

    //获取文章分类
    public function actionArticleCategory(){
        $articles=ActicleCategory::find()->asArray()->all();
        return ['success'=>true,'msg'=>'','data'=>$articles];
    }
    //获取文章分类对应的文章
    public function actionGetArticle(){
        if(\Yii::$app->request->isGet){
            if($art_id=\Yii::$app->request->get('art_id')){
                $arts=Acticle::find()->where(['article_category_id'=>$art_id])->asArray()->all();
                if($arts){
                    return ['success'=>true,'msg'=>'','data'=>$arts];
                }
                return ['success'=>false,'msg'=>'数据不存在'];
            }
            return ['success'=>false,'msg'=>'数据不存在'];
        }
        return ['success'=>false,'msg'=>'非get请求'];
    }
    //获取文章的 文章分类
    public function actionGetArticleCategory(){
        if(\Yii::$app->request->isGet){
            if($art_id=\Yii::$app->request->get('art_id')){
                $article=Acticle::findOne(['id'=>$art_id]);
                if($article){
                    $articlecategory=ActicleCategory::find()->where(['id'=>$article->article_category_id])->asArray()->one();
                    if($articlecategory){
                        return ['success'=>true,'msg'=>'','data'=>$articlecategory];
                }
                    return ['success'=>false,'msg'=>'数据不存在'];
                }
                return ['success'=>false,'msg'=>'数据不存在'];
            }
            return ['success'=>false,'msg'=>'数据不存在'];
        }
        return ['success'=>false,'msg'=>'非get请求'];
    }


    //购物车  添加商品到购物车  修改购物车商品数量 删除购物车某商品， 清空购物车，获取购物车所有商品
    //添加商品到购物车
    public function actionAddCart(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $goods_id=$request->post('goods_id');
            $amount=$request->post('amount');
//            var_dump($goods_id,$amount);exit;
            if(\Yii::$app->user->isGuest){
                $cookies=\Yii::$app->request->cookies;
                $cookie=$cookies->get('cart');
                if($cookie == null){
                    $cart = [];
                }else{
                    $cart = unserialize($cookie->value); //$cart = [2=>10];
                }
                $cookie=\Yii::$app->response->cookies;
                if(key_exists($goods_id,$cart)){
                    $cart[$goods_id]+=$amount;
                }else{
                    $cart[$goods_id]=$amount;
                }
                $cookies=new Cookie([
                    'name'=>'cart','value'=>serialize($cart)
                ]);
                $cookie->add($cookies);
                return ['success'=>true,'msg'=>'添加到购物车成功','data'=>$cookie];
            }else{
                $member_id=\Yii::$app->user->id;
                $cartone=Cart::findOne(['member_id'=>$member_id,'goods_id'=>$goods_id]);
                if($cartone){
                    $cartone->amount+=$amount;
                    $cartone->update();
                    return ['success'=>true,'msg'=>'保存成功'];
                }else{
                    $cart=new Cart();
                    $cart->goods_id=$goods_id;
                    $cart->amount=$amount;
                    $cart->member_id=$member_id;
                    if($cart->validate()){
                        $cart->save();
                        return ['success'=>true,'msg'=>'保存成功'];
                    }
                    return ['success'=>false,'msg'=>'验证失败'];
                }
            }

        }
        return ['success'=>false,'msg'=>'非POST提交'];
    }
    //修改购物车商品数量
    public function actionEditCart(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $goods_id=$request->post('goods_id');
            $amount=$request->post('amount');
            if(\Yii::$app->user->isGuest){
                $cookies=\Yii::$app->request->cookies;
                $cookie=$cookies->get('cart');
                if($cookie == null){
                    $cart = [];
                }else{
                    $cart = unserialize($cookie->value); //$cart = [2=>10];
                }
                if($amount!=0){
                    $cart[$goods_id] = $amount;
                }else{
                    if(key_exists($goods_id,$cart)) unset($cart[$goods_id]);
                }
                $cookie=\Yii::$app->response->cookies;
                //上面拿到保存在cookie的数据 然后判断当前id为键 的商品存不存在于cookie中 如果存在就追加 如果不存在 就放到cookie2位数组中
                //$array[3=>33]
                $cookies=new Cookie([
                    'name'=>'cart','value'=>serialize($cart)
                ]);
                $cookie->add($cookies);
                return ['success'=>true,'msg'=>'修改成功','data'=>$cookie];
            }else{
                $member_id=\Yii::$app->user->id;
                $cart=Cart::findOne(['member_id'=>$member_id,'goods_id'=>$goods_id]);

                if($cart){
                    $cart->amount=$amount;
                    if($cart->update()){
                        return ['success'=>true,'msg'=>'修改成功'];
                    }
                    return ['success'=>true,'msg'=>'修改失败'];
                }
                return ['success'=>false,'msg'=>'数据不存在'];
            }
        }
        return ['success'=>false,'msg'=>'非POST提交'];
    }
    //删除购物车某商品
    public function actionDelCart(){
        $request=\Yii::$app->request;


        if($request->isGet){
            $member_id=\Yii::$app->user->id;
            $goods_id=$request->get('goods_id');
            if(\Yii::$app->user->isGuest){
                $cookies=\Yii::$app->request->cookies;
                $cookie=$cookies->get('cart');
                if($cookie == null){
                    $cart = [];
                }else{
                    $cart = unserialize($cookie->value); //$cart = [2=>10];
                }
                if(key_exists($goods_id,$cart)) unset($cart[$goods_id]);
                return ['success'=>true,'msg'=>'删除成功','data'=>$cart];
            }else{
                $cart=Cart::findOne(['goods_id'=>$goods_id,'member_id'=>$member_id]);
                if($cart->delete()){
                    return ['success'=>true,'msg'=>'删除成功'];
                }
                return ['success'=>false,'msg'=>'删除失败'];
            }

        }
        return ['success'=>false,'msg'=>'非GET提交'];
    }
    //清除购物车
    public function actionCleanCart(){
        $request=\Yii::$app->request;
        if(\Yii::$app->user->isGuest){
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            $recookie=\Yii::$app->response->cookies;
            $recookie->remove($cookie);
            return ['success'=>true,'msg'=>'清空购物车完成','data'=>$cookie];
        }
        $member_id=\Yii::$app->user->id;
        $carts=Cart::findAll(['member_id'=>$member_id]);
        if($carts){
            foreach($carts as $cart){
                $cart->delete();
            }
            return ['success'=>true,'msg'=>'清空购物车完成'];
        }
        return ['success'=>false,'msg'=>'数据异常'];

    }
    //获取购物车所有商品
    public function actionCartAll(){
        $request=\Yii::$app->request;
        if(\Yii::$app->user->isGuest){
            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');
            if($cookie == null){
                $cart = [];
            }else{
                $cart = unserialize($cookie->value); //$cart = [2=>10];
            }
            return ['success'=>true,'msg'=>'','data'=>$cart];
        }
        $member_id=\Yii::$app->user->id;
            $carts=Cart::find()->where(['member_id'=>$member_id])->asArray()->all();
            if($carts){
                return ['success'=>true,'msg'=>'','data'=>$carts];
            }
        return ['success'=>false,'msg'=>'数据异常'];
    }

    //订单   获取支付方法，获取送货方式，提交订单，获取当前用户订单列表，取消订单
    public function actionGetDelivery(){
        $request=\Yii::$app->request;
        if(\Yii::$app->user->isGuest){
            return ['success'=>false,'msg'=>'当前是游客登录'];
        }
        $member_id=\Yii::$app->user->id;
        if($request->isGet){
            if($order_id=$request->get('order_id')){
                $order=Order::find()->where(['member_id'=>$member_id,'id'=>$order_id])->asArray()->all();
                if($order){
                    return ['success'=>true,'msg'=>'','data'=>$order[0]['delivery_name']];
                }
                return ['success'=>false,'msg'=>'不存在的订单'];
            }
            return ['success'=>false,'msg'=>'错误请求'];
        }
        return ['success'=>false,'msg'=>'非get请求'];
    }
//获取送货方式
    public function actionGetPayment(){
        $request=\Yii::$app->request;
        if(\Yii::$app->user->isGuest){
            return ['success'=>false,'msg'=>'当前是游客登录'];
        }
        $member_id=\Yii::$app->user->id;
        if($request->isGet){
            if($order_id=$request->get('order_id')){
                $order=Order::find()->where(['member_id'=>$member_id,'id'=>$order_id])->asArray()->all();
                if($order){
                    return ['success'=>true,'msg'=>'','data'=>$order[0]['payment_name']];
                }
                return ['success'=>false,'msg'=>'不存在的订单'];
            }
            return ['success'=>false,'msg'=>'错误请求'];
        }
        return ['success'=>false,'msg'=>'非get请求'];
    }
    //获取当前用户订单列表
    public function actionGetOrders()
    {

        if (\Yii::$app->user->isGuest) {
            return ['success' => false, 'msg' => '当前是游客登录'];
        }
        $member_id = \Yii::$app->user->id;


        $order = Order::find()->where(['member_id' => $member_id])->asArray()->all();
        if ($order) {
            return ['success' => true, 'msg' => '', 'data' => $order];
        }
        return ['success' => false, 'msg' => '不存在的订单'];

    }
    //取消订单    修改要使用原生update方法 上网查资料
    public function actionDelOrder(){
        $request=\Yii::$app->request;
        if(\Yii::$app->user->isGuest){
            return ['success'=>false,'msg'=>'当前是游客登录'];
        }
        $member_id=\Yii::$app->user->id;
        if($request->isGet){
            if($order_id=$request->get('order_id')){
                $order=Order::findOne(['member_id'=>$member_id,'id'=>$order_id]);
//var_dump($order['status']);exit;
                if($order){
                    $order->status=0;
                    if($order->update()){
                        return ['success'=>true,'msg'=>'取消订单成功'];
                    }
                        return ['success'=>true,'msg'=>'取消订单失败'];
                    }
                    return ['success'=>false,'msg'=>'订单不存在
                    '];
                }
                return ['success'=>false,'msg'=>'参数错误'];
            }
        return ['success'=>false,'msg'=>'非get请求'];
    }
    //提交订单
    public function actionOrderUp(){
        $request=\Yii::$app->request;
        if(\Yii::$app->user->isGuest){
            return ['success'=>false,'msg'=>'当前是游客登录'];
        }
        //3个参数  delivery  payment  address_id  total计算后的值
        if($request->isPost){
            $member_id=\Yii::$app->user->id;
            $delivery=$request->post('delivery');
            $payment=$request->post('payment');
            $address_id=$request->post('address_id');
            $total=$request->post('total');
            if(!$delivery || !$payment || !$address_id || !$total){
                return ['success'=>false,'msg'=>'数据请求错误'];
            }
            $delivery_name='';
            $delivery_price='';
            $order=new Order();
            foreach(Order::$delivery as $deli){
                if($deli['delivery_id'] == $delivery){

                    $delivery_name=$deli['delivery_name'];
                    $delivery_price=$deli['delivery_price'];
                }
            }
            $payment_name='';
            foreach(Order::$payment as $pay){
                if($pay['payment_id'] == $payment){
                    $payment_name=$pay['payment_name'];
                }
            }
            $address=Address::findOne(['id'=>$address_id,'member_id'=>$member_id]);
            $order->member_id=$member_id;
            $order->name=$address->name;
            $order->province=$address->province;
            $order->city=$address->city;
            $order->area=$address->area;
            $order->address=$address->address;
            $order->tel=$address->tel;
            $order->delivery_id=$request->post('delivery');
            $order->delivery_name=$delivery_name;
            $order->delivery_price=$delivery_price;
            $order->payment_id=$request->post('payment');
            $order->payment_name=$payment_name;
            $order->total=$request->post('total');;
            $order->status=1;
            $order->trade_no='无';
            $order->create_time=time();
            $order->save();
//            var_dump($order->save(false));exit;
            $id=$order->id;
            $member_id=\Yii::$app->user->id;
            $beginTransaction=\Yii::$app->db->beginTransaction();
            try{
                $order_goods=new OrderGoods();
                $carts=Cart::findAll(['member_id'=>$member_id]);
                foreach($carts as $cart){

                    $good=Goods::findOne(['id'=>$cart->goods_id]);
                    if($good->stock<$cart->amount){
                        throw new NotFoundHttpException($good->name.'商品库存不足');
                    }
                    $order_goods->order_id=$id;
                    $order_goods->goods_id=$cart->goods_id;
                    $order_goods->goods_name=$cart->goods->name;
                    $order_goods->logo=$cart->goods->logo;
                    $order_goods->price=$cart->goods->shop_price;
                    $order_goods->amount=$cart->amount;
                    $order_goods->total=$cart->amount*$cart->goods->shop_price;
                    $order_goods->save(false);
                    $order_goods->isNewRecord = true;
                    $order_goods->id = null;
                    $good=Goods::findOne(['id'=>$cart->goods_id]);
                    $good->stock-=$cart->amount;
                    $good->save();
                    $cart->delete();
                }
                $beginTransaction->commit();//事务提交
                return ['success'=>true,'msg'=>'提交订单成功'];
            }catch (Exception $e){

                $beginTransaction->rollBack();//事务回滚
                return ['success'=>true,'msg'=>'失败'];
            }
        }
        return ['success'=>false,'msg'=>'非GET提交'];
    }


    //高级api  分页  验证码 发送短信  文件上传
//验证码
    public function actions(){
        return [
            'captcha'=>[
                'class'=>'yii\captcha\CaptchaAction',
                'maxLength'=>3,
                'minLength'=>3,
                'height' => 50,
                'width' => 80,//这里可以设置宽和高，但是如果视图中有style，就会覆盖此处的宽和高
            ]
            //refresh=1  就是重置 图片的url地址 访问新生成地址就访问刷新的图片了
        ];
    }
    //文件上传
    public function actionUpload(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $img=UploadedFile::getInstanceByName('img');
            if($img){
                $filename='./upload/'.uniqid().'.'.$img->extension;
                $res=$img->saveAs(\Yii::getAlias('@webroot').$filename,0);
                if($res){
                    return ['success'=>true,'msg'=>'保存成功','data'=>$filename];
                }
                return ['success'=>false,'msg'=>'保存失败'];
            }
            return ['success'=>false,'msg'=>'图片不正确'];
        }
        return ['success'=>false,'msg'=>'非POST提交'];
    }
//分页
//发送短信
    public function actionSendSms(){
        if(\Yii::$app->request->isPost){
            $tel=\Yii::$app->request->post('tel');
            if(!preg_match('/^1[34578]\d{9}$/',$tel)){
                return ['search'=>false, 'msg'=>'电话号码不正确',];
            }
            $value=\Yii::$app->cache->get('tel_time'.$tel);
            $s=time()-$value;
            if($s<60){
                return ['search'=>false, 'msg'=>'请'.(60-$s).'秒后再试',];
            }
            $code=rand(1000,9999);
//        $yzm=\Yii::$app->sms->setNum($tel)->setSmsParam(['code' => $code])->setSend();
            if($code){
                \Yii::$app->cache->set('tel_'.$tel,$code,5*60);
                \Yii::$app->cache->set('tel_time'.$tel,time(),5*60);
                return ['search'=>true, 'code'=>$code, 'msg'=>'发送短信成功',];
            }else{
                return ['search'=>false, 'msg'=>'发送失败',];
            }
        }
        return ['search'=>false, 'msg'=>'非POST请求',];
    }

    public function actionGoodsList(){
        $request=\Yii::$app->request;
        if($request->isGet){
            $per_page=$request->get('per_page',3);
            $page=$request->get('page',1);
            $keyword=$request->get('keyword');

            $query=Goods::find();

            if($keyword){
                $query->andWhere(['like','name',$keyword]);
            }
            $total=$query->count();
            $goods=$query->offset(($page-1)*$per_page)->limit($per_page)->asArray()->all();
            return ['search'=>true,'msg'=>'','data'=>[
                'per_page'=>$per_page,
                'page'=>$page,
                'total'=>$total,
                'goods'=>$goods,
            ]];
        }
        return ['search'=>false, 'msg'=>'非GET请求',];
    }

}