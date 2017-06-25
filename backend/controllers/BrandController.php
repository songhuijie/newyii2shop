<?php
namespace backend\controllers;

use backend\filters\UserFilter;
use backend\models\Brand;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;
use crazyfd\qiniu\Qiniu;
class BrandController extends Controller{
    public function actionAdd(){
        $model=new Brand();
        if($model->load(\Yii::$app->request->post())){
//            var_dump($model);exit;
//            $model->imgFile=Upload    edFile::getInstance($model,'imgFile');
            if($model->validate()){
               /* if($model->imgFile){
                    $filename='/images/brand'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$filename,false);
                    $model->logo=$filename;
                }*/
                $model->save();

                \Yii::$app->session->setFlash('success','添加商品成功');
                return $this->redirect(['brand/index']);
            }
        }
        $sub='添加';
        return $this->render('add',['model'=>$model,'sub'=>$sub]);
    }
    //展示 状态不是删除的商品
    public function actionIndex(){
        $brands=Brand::find()->where(['>','status','-1']);
        $pagelation=new Pagination([
            'totalCount'=>$brands->count(),
            'defaultPageSize'=>5,
        ]);
        $model=$brands->offset($pagelation->offset)->limit($pagelation->limit)->all();
        return $this->render('index',['model'=>$model,'pagelation'=>$pagelation]);
    }
    //修改
    public function actionEdit($id){
        $model=Brand::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post())){
//            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
//                if($model->imgFile){
//                    $filename='/images/brand'.uniqid().'.'.$model->imgFile->extension;
//                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$filename,false);
//                    $model->logo=$filename;
//                }
                $model->save();
                \Yii::$app->session->setFlash('success','修改商品成功');
                return $this->redirect(['brand/index']);
            }
        }
        $sub='修改';
        return $this->render('add',['model'=>$model,'sub'=>$sub]);
    }
    //静态删除
    public function actionDel($id) {
        $model=Brand::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        \Yii::$app->session->setFlash('success','删除商品成功');
        return $this->redirect(['brand/index']);
    }
//配置接收图片
    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
               /* 'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },*/
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $filename=$action->getWebUrl();
                    $qiniu=\Yii::$app->Qiniu;
                    $qiniu->uploadFile(\Yii::getAlias('@webroot').$filename,$filename);
                    $url = $qiniu->getLink($filename);
                    $action->output['fileUrl'] =[$url,$filename];
//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }
    //测试
    /*public function actionTest(){
        $ak = 'KZ96ez0ladEdYzJm88E9ny3aQkbZBWi5vXy1eP1Z';
        $sk = 'oYh4ySoX2pZZh0mKw1LTKhiHIuRaLd6GnSS9gAGl';
        $domain = 'http://or9qpxgdy.bkt.clouddn.com/';
        $bucket = 'shj1995';

        $qiniu = new Qiniu($ak, $sk,$domain, $bucket);
        $filename='/upload/1.jpg';
        $qiniu->uploadFile(\Yii::getAlias('@webroot').$filename,$filename);
        $url = $qiniu->getLink($filename);
        var_dump($url);
    }*/
    public function actionAlert(){
    return $this->render('alert');
}
    public function actionAjaxdel(){

        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->get('id');
            $brand=Brand::findOne(['id'=>$id]);
            $brand->status=-1;
            if($brand->save()){
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                        'search'=>true,
                        'msg'=>'成功',
                ];
            }else{
                return [
                    'search'=>false,
                    'msg'=>'失败',
                ];
            }
        }
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