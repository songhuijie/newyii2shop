<?php

namespace backend\controllers;

use backend\filters\UserFilter;
use backend\models\Login;
use backend\models\Password;
use backend\models\SignupForm;
use backend\models\UserBackend;
use yii\debug\models\search\Log;
use yii\rbac\DbManager;
use yii\web\Request;

class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model=UserBackend::find()->where(['>','status','-1'])->all();
        return $this->render('index',['model'=>$model]);
    }
    public function actionAdd(){
        $model=new UserBackend(['scenario'=>'add']);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            $model->saverole($model->id,$model->roleoptions);
            \Yii::$app->session->setFlash('success','添加用户成功');
            return $this->redirect(['user/index']);
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionEdit($id){
        $model=UserBackend::findOne(['id'=>$id]);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
           $model->save();
           $model->updaterole($id);
            \Yii::$app->session->setFlash('success','修改用户成功');
            return $this->redirect(['user/index']);
        }
        $model->reload($id);
        return $this->render('add',['model'=>$model]);
    }
    public function actionLogin(){
        $model=new Login();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
//            var_dump($model->cookie);exit;
            if($model->validate()){
                \Yii::$app->getSession()->setFlash('success', "登录成功！");
                return $this->redirect(['site/index']);
            }else{
                \Yii::$app->getSession()->setFlash('success', "用户名或者密码不正确！");
            }
        }
    return $this->render('login',['model'=>$model]);
    }
    public function actionLogout(){
        echo '注销成功';
        \Yii::$app->user->logout();
        \Yii::$app->getSession()->setFlash('warning', "注销成功！");
        return $this->redirect(['user/login']);
    }
    public function actionPassword($id){

        $user=UserBackend::findOne(['id'=>$id]);
        $model=new Password();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if(!\Yii::$app->security->validatePassword($model->old_password,$user->password_hash)){
                \Yii::$app->getSession()->setFlash('danger', "密码错误,请确认后再输入！");
//                echo '密码错误,请确认后再输入'; exit;
            }else{
                if($model->new_password != $model->new2_password){
                    \Yii::$app->getSession()->setFlash('danger', "2次输入密码不一致！");
                }elseif ($model->validate()){
                    $user->password_hash=\Yii::$app->security->generatePasswordHash($model->new_password);
                    $user->save(false);
                    \Yii::$app->getSession()->setFlash('success', "密码修改成功！");
                    return $this->redirect(['user/index']);
                }
            }
        }

       return  $this->render('password',['model'=>$model]);
    }
    public function actionDel($id){
        $user=UserBackend::findOne(['id'=>$id]);
        $user->status=-1;
        $user->save();
        \Yii::$app->session->setFlash('danger','删除成功');
        return $this->redirect(['user/index']);
    }


    //当前页面的验证规则
        public function behaviors()
        {
            return [
                'rbac'=>[
                    'class'=>UserFilter::className(),
                    'only'=>['del','add','edit','index']
                ]
            ];
        }

}
