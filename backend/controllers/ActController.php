<?php
namespace backend\controllers;
use backend\filters\UserFilter;
use backend\models\Acticle;
use backend\models\ActicleCategory;
use backend\models\Artdetail;
use yii\data\Pagination;
use yii\web\Controller;

class ActController extends Controller {
    public function actionAdd(){
        $model=new Acticle();
        $acttocate=ActicleCategory::find()->all();
        $actdetail=new Artdetail();
        if($model->load(\Yii::$app->request->post()) && $actdetail->load(\Yii::$app->request->post())){
            if($model->validate() && $actdetail->validate()){
               if($model->save()){
                   $actdetail->article_id=$model->id;
                   if($actdetail->save()){
                            \Yii::$app->session->setFlash('success','添加文章成功');
                            return $this->redirect(['act/index']);
                   }else{
                       var_dump($actdetail->getErrors());exit;
                   }
               }else{
                   var_dump($model->getErrors());exit;
               }
            }else{
                var_dump($model->getErrors());

        }
        }
        return $this->render('add',['model'=>$model,'acttocate'=>$acttocate,'actdetail'=>$actdetail]);
    }
    public function actionIndex(){
        $acticles=Acticle::find()->where(['>','status','-1']);
        $pagelation=new Pagination([
            'totalCount'=>$acticles->count(),
            'defaultPageSize'=>2,
        ]);
        $model=$acticles->offset($pagelation->offset)->limit($pagelation->limit)->all();
        return $this->render('index',['model'=>$model,'pagelation'=>$pagelation]);
    }

    public function actionEdit($id){
        $model=Acticle::findOne(['id'=>$id]);
        $acttocate=ActicleCategory::find()->all();
        $actdetail=Artdetail::findOne(['article_id'=>$id]);
        if($model->load(\Yii::$app->request->post()) && $actdetail->load(\Yii::$app->request->post())){
            if($model->validate() && $actdetail->validate()){
                if($model->save()){
                    if($actdetail->save()){
                        \Yii::$app->session->setFlash('success','修改文章成功');
                        return $this->redirect(['act/index']);
                    }else{
                        var_dump($actdetail->getErrors());exit;
                    }
                }else{
                    var_dump($model->getErrors());exit;
                }
            }else{
                var_dump($model->getErrors());

            }
        }
        return $this->render('add',['model'=>$model,'acttocate'=>$acttocate,'actdetail'=>$actdetail]);
    }
    public function actionDel($id){
        $model=Acticle::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        \Yii::$app->session->setFlash('danger','删除文章成功');
        return $this->redirect(['act/index']);
    }
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
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
