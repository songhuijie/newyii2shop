<?php

namespace backend\controllers;

use backend\filters\UserFilter;
use backend\models\GoodsCategory;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $goods=GoodsCategory::find();

        $pagelation=new Pagination([
            'totalCount'=>$goods->count(),
            'defaultPageSize'=>5,
        ]);
        $model=$goods->offset($pagelation->offset)->limit($pagelation->limit)->all();
        return $this->render('index',['model'=>$model,'pagelation'=>$pagelation]);
    }
    public function actionTest(){
        return $this->render('test');
    }

    public function actionAdd(){
        $model=new GoodsCategory();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->parent_id){
                $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                $model->prependTo($parent);
            }else{
                $model->makeRoot();
            }
            \Yii::$app->session->setFlash('success','添加分类成功');
            return $this->redirect(['goods-category/list']);
        }
        $options=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类']],GoodsCategory::find()->asArray()->all());
        $sub='添加';
        return $this->render('add',['model'=>$model,'options'=>$options,'sub'=>$sub]);
    }
    public function actionEdit($id){
        $model=GoodsCategory::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->parent_id){
                $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                $model->prependTo($parent);
            }else{
                if($model->getOldAttribute('parent_id')==0){
                    $model->save();
                }else{
                    $model->makeRoot();
                }
            }
            \Yii::$app->session->setFlash('success','修改成功');
            return $this->redirect(['goods-category/index']);
        }
        $options=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类']],GoodsCategory::find()->asArray()->all());
        $sub='修改';
        return $this->render('add',['model'=>$model,'options'=>$options,'sub'=>$sub]);
    }
//    public function actionDel($id){
//        $model=GoodsCategory::findOne(['id'=>$id]);
//        $model->delete();
//        \Yii::$app->session->setFlash('success','删除成功');
//        return $this->redirect(['goods-category/index']);
//    }
    public function actionList(){
        $models=GoodsCategory::find()->orderBy('tree,lft')->all();
        return $this->render('list',['models'=>$models]);
    }
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
