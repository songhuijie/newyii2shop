<?php

namespace backend\controllers;

use backend\filters\UserFilter;
use backend\models\PermissionForm;
use backend\models\RoleForm;

class RbacController extends \yii\web\Controller
{
    //添加权限
    public function actionAddPermission(){
        $model=new PermissionForm();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            if($model->Permission()){
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['permission-index']);
            }
        }
        $sub='添加';
        return $this->render('add-permission',['model'=>$model,'sub'=>$sub]);
    }

    //权限展示
    public function actionPermissionIndex()
    {
        $models=\Yii::$app->authManager->getPermissions();
        return $this->render('index',['models'=>$models]);
    }
    //权限修改
    public function actionEditPermission($name){
        //获取当前权限的信息
        $permission=\Yii::$app->authManager->getPermission($name);
        //使用表单模型
        $model=new PermissionForm();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            if($model->updatePermission($permission)){
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['permission-index']);
            }
        }
        $sub='修改';
        $model->reload($permission);
        return $this->render('add-permission',['model'=>$model,'sub'=>$sub]);
    }
    //权限删除
    public function actionDelPermission($name){
        $permission=\Yii::$app->authManager->getPermission($name);
        if(\Yii::$app->authManager->remove($permission)){
            \Yii::$app->session->setFlash('success','删除成功');
            return $this->redirect(['permission-index']);
        };
    }
    //添加角色
    public function actionAddRole(){
        $model=new RoleForm();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            if($model->role()){
                \Yii::$app->session->setFlash('success','添加角色成功');
                return $this->redirect(['rbac/role-index']);
            }
        }
        $sub='添加';
        return $this->render('add-role',['model'=>$model,'sub'=>$sub]);
    }
    //角色展示
    public function actionRoleIndex(){
        $roles=\Yii::$app->authManager->getRoles();
        return $this->render('role-index',['roles'=>$roles]);
    }
    //角色修改
    public function actionEditRole($name){
        $role=\Yii::$app->authManager->getRole($name);
        $model=new RoleForm();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            if($model->updaterole($role)){
                \Yii::$app->session->setFlash('success','修改角色成功');
                return $this->redirect(['rbac/role-index']);
            }
        }
        $sub='修改';
        $model->reload($role);
        return $this->render('add-role',['model'=>$model,'sub'=>$sub]);
    }
    //角色删除
    public function actionDelRole($name){
        $authManager=\Yii::$app->authManager;
        $role=$authManager->getRole($name);
        if($authManager->removeChildren($role) && $authManager->remove($role)){
            \Yii::$app->session->setFlash('success','删除角色成功');
            return $this->redirect(['rbac/role-index']);
        }
    }
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>UserFilter::className(),
                'only'=>['del-role','add-role','edit-role','role-index','del-permission','add-permission','edit-permission','permission-index']
            ]
        ];
    }
}
