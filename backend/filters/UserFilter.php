<?php
namespace backend\filters;
use yii\base\ActionFilter;
use yii\web\HttpException;

class UserFilter extends ActionFilter{
    public function beforeAction($action)
    {
        if(\Yii::$app->user->isGuest){
            //判断 如果是游客的话 跳到登录页面
            $action->controller->redirect(\Yii::$app->user->loginUrl);
            //必须需要一个return false 或者true
            return false;
        }elseif (!\Yii::$app->user->can($action->uniqueId)){
            //判断用户没有改页面的权限 将抛出一个403访问权限错误
            throw new HttpException(403,'你没有权限访问该页面');
        }

        //返回当前路由 相当于return false
        return parent::beforeAction($action);
    }
}