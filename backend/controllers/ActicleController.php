<?php
namespace backend\controllers;


use backend\filters\UserFilter;
use backend\models\Acticle;
use backend\models\ActicleCategory;
use xj\uploadify\UploadAction;
use yii\base\Response;
use yii\data\Pagination;
use yii\web\Controller;

class ActicleController extends Controller {
    public function actionAdd(){
        $model=new ActicleCategory();
        if($model->load(\Yii::$app->request->post())){
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','添加文章类型成功');
                return $this->redirect(['acticle/index']);
            }
        }
        $sub='添加';
        return $this->render('add',['model'=>$model,'sub'=>$sub]);
    }

    public function actionIndex(){
        $acticles=ActicleCategory::find()->where(['>','status','-1']);

        $pagelation=new Pagination([
            'totalCount'=>$acticles->count(),
            'defaultPageSize'=>5,
        ]);
        $model=$acticles->offset($pagelation->offset)->limit($pagelation->limit)->all();
        return $this->render('index',['model'=>$model,'pagelation'=>$pagelation]);
    }

    public function actionEdit($id){
        $model=ActicleCategory::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post())){
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','修改文章类型成功');
                return $this->redirect(['acticle/index']);
            }
        }
        $sub='修改';
        return $this->render('add',['model'=>$model,'sub'=>$sub]);
    }
    public function actionDel($id){
        $acticle=ActicleCategory::findOne(['id'=>$id]);
        $acticle->status=-1;
        $acticle->save();
        \Yii::$app->session->setFlash('success','删除文章成功');
        return $this->redirect(['acticle/index']);
    }
    public function actionCreate()
    {

        $model = new ActicleCategory();
        if(\Yii::$app->request->isGet){
            return $this->renderAjax('add', [
                'model' => $model,
            ]);
        }
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        //var_dump(\Yii::$app->request->post());exit;
        if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return ['error'=>1,'msg'=>'添加成功'];
        }
        return ['error'=>0,'msg'=>'操作失败'];
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