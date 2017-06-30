<?php

namespace frontend\controllers;

use frontend\models\Cart;
use frontend\models\Login;
use frontend\models\Member;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;
use frontend\models\PasswordForm;
use frontend\models\RepasswordForm;


class MemberController extends \yii\web\Controller
{
    public $layout='login.php';
    public function actionIndex()
    {
        return $this->render('index');
    }
    //注册页面 接收数据保存到数据库
    public function actionRegist(){
        $model=new Member();
        $model->setScenario(Member::SCENARIO_REGISTER);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->repass($model->password);
            $model->save(false);
            \Yii::$app->session->setFlash('success','注册成功');
            return $this->redirect(['member/login']);
        }
        return $this->render('regist',['model'=>$model]);
    }
    //登录成功的时候
    public function actionLogin(){
        $model=new Login();
        $model->setScenario(Login::SCENARIO_LOGIN);
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            if($model->login($model)){
                \Yii::$app->session->setFlash('success','登陆成功');
                //登录成功保存cookie中的订单 并删除cookie
                $cookies=\Yii::$app->request->cookies;
                $cookie=$cookies->get('cart');
                if($cookie!=null){
                    $cart = unserialize($cookie->value); //$cart = [2=>10];
                    $member_id=\Yii::$app->user->id;
                    //循环保存购物车的所有cookie信息
                    if($cart){
                        $cartt=Cart::findAll(['member_id'=>$member_id]);
                        foreach($cartt as $c){
                            if(key_exists($c->goods_id,$cart)){
                                $c->amount=intval($c->amount)+intval($cart[$c->goods_id]);
                                $c->save();
                                unset($cart[$c->goods_id]);
                            }
                        }
                        $carts=new Cart();
                        foreach($cart as $k=>$v){
                            $carts->goods_id=$k;
                            $carts->amount=$v;
                            $carts->member_id=$member_id;
                            //开启事务
                            $carts->save();
                            $carts->isNewRecord = true;
                            $carts->id = null;
                        }
                    }
                    //保存成功后 删除cookie cart的所有信息
                    $recookie=\Yii::$app->response->cookies;
                    $recookie->remove($cookie);
                    return $this->redirect(['pay/mycar']);
                }

                return $this->redirect(['address/add']);
            };
        }
        return $this->render('login',['model'=>$model]);
    }
    public function actionLogout(){
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('success','注销成功');
        return $this->redirect(['member/login']);
    }
    //发送手机号码验证
    public function actionSendSms(){
        $tel=\Yii::$app->request->post('tel');
        if(!preg_match('/^1[34578]\d{9}$/',$tel)){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'search'=>false,
                'msg'=>'电话号码不正确',
            ];
        }
        $code=rand(1000,9999);
//        $yzm=\Yii::$app->sms->setNum($tel)->setSmsParam(['code' => $code])->setSend();
        if($code){
            \Yii::$app->cache->set('tel_'.$tel,$code,5*60);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'search'=>true,
                'code'=>$code,
                'msg'=>'发送短信成功',
            ];
        }else{
            echo  '电话号码不正确';
            return false;
        }

    }
//忘记密码的展示页 和提交信息
    public function actionRepassword(){
        $model=new RepasswordForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->reload($model)){
                return $this->render('guodu');
            }
        }
        return $this->render('repassword',['model'=>$model]);
    }
    //修改密码的
    public function actionPassword($id){
        $model=new PasswordForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->reload($model)){
                \Yii::$app->session->setFlash('success','密码修改成功');
                return $this->redirect(['member/login']);
            }
        }
        return $this->render('password',['model'=>$model,'id'=>$id]);
    }
    public function actionSms(){
        /*$config = [
            'app_key'    => '24479822',
            'app_secret' => '20af6d8ee475b9e351a787a736b7b69a',
            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];


// 使用方法一
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;
$code=rand(100000, 999999);
        $req->setRecNum('18080952663')
            ->setSmsParam([
                'code' => $code
            ])
            ->setSmsFreeSignName('阿杰网站')
            ->setSmsTemplateCode('SMS_71740036');

        $resp = $client->execute($req);
        var_dump($resp);
        var_dump($code);
        $code=rand(1000, 9999);
        $yzm=\Yii::$app->sms->setNum(18080952663)->setSmsParam(['code' => $code])->setSend();
        if($yzm){
            echo '成功';
            var_dump($code);
            var_dump($yzm);
        }
    }*/
}
//发送邮件163格式
    public function actionEmail(){
        $mail= \Yii::$app->mailer->compose();
        $mail->setFrom('18080952663@163.com');
        $mail->setTo('18080952663@163.com');
        $mail->setSubject("邮件测试");
//$mail->setTextBody('zheshisha ');   //发布纯文字文本
        $mail->setHtmlBody("<b style='color:red'>问我我我我我</b>");    //发布可以带html标签的文本
        if($mail->send())
            echo "success";
        else
            echo "failse";
        die();
    }
}
