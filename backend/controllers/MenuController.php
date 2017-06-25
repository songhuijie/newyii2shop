<?php

namespace backend\controllers;

use backend\models\Menu;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class MenuController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model=Menu::find();
        $pagelation=new Pagination([
            'totalCount'=>$model->count(),
            'defaultPageSize'=>5,
        ]);
        $models=$model->offset($pagelation->offset)->limit($pagelation->limit)->all();
        return $this->render('index',['models'=>$models,'pagelation'=>$pagelation]);
    }
    public function actionAdd(){
        $model=new Menu();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            $model->save();
        \Yii::$app->session->setFlash('success','添加菜单成功');
        return $this->redirect(['menu/index']);
        }
        $parent=['0'=>'顶级菜单']+ArrayHelper::map(Menu::findAll(['parent_id'=>0]),'id','label');
        return $this->render('add',['model'=>$model,'parent'=>$parent]);
    }
    public function actionEdit($id){
        $model=Menu::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','修改菜单成功');
            return $this->redirect(['menu/index']);
        }
        $parent=['0'=>'顶级菜单']+ArrayHelper::map(Menu::findAll(['parent_id'=>0]),'id','label');
        return $this->render('add',['model'=>$model,'parent'=>$parent]);
    }
    public function actionDel($id)
    {
        $model = Menu::findOne(['id' => $id]);
        $model->delete();
        \Yii::$app->session->setFlash('success','删除菜单成功');
        return $this->redirect(['menu/index']);

    }
}
