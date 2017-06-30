<?php

namespace backend\controllers;

use backend\component\SphinxClient;
use backend\filters\UserFilter;
use backend\models\ActicleCategory;
use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsCount;
use backend\models\Goodsimg;
use backend\models\GoodsSearch;
use crazyfd\qiniu\Qiniu;
use backend\models\GoodsIntro;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $search = new GoodsSearch();
        $query=Goods::find()->where(['>','status','-1']);
//        $search->search($query);
        if($keyword=\Yii::$app->request->get('keyword')){
            $cl = new SphinxClient();
            $cl->SetServer ( '127.0.0.1', 9312);
            $cl->SetConnectTimeout ( 10 );
            $cl->SetArrayResult ( true );
            $cl->SetMatchMode ( SPH_MATCH_EXTENDED2);
            $cl->SetLimits(0, 1000);
            $res = $cl->Query($keyword, 'goods');
            if(!isset($res['matches'])){
                $query->where(['id'=>0]);
            }else{
                $ids=ArrayHelper::map($res['matches'],'id','id');
                $query->where(['in','id',$ids]);
            }
        }
       $pagelation=new Pagination([
            'totalCount'=>$query->count(),
            'defaultPageSize'=>3,
        ]);
        $models=$query->offset($pagelation->offset)->limit($pagelation->limit)->all();

            $keywords = array_keys($res['words']);
            $options = array(
                'before_match' => '<span style="color:red;">',
                'after_match' => '</span>',
                'chunk_separator' => '...',
                'limit' => 80, //如果内容超过80个字符，就使用...隐藏多余的的内容
            );
//关键字高亮
//        var_dump($models);exit;
            foreach ($models as $index => $item) {
                $name = $cl->BuildExcerpts([$item->name], 'goods', implode(',', $keywords), $options); //使用的索引不能写*，关键字可以使用空格、逗号等符号做分隔，放心，sphinx很智能，会给你拆分的
                $models[$index]->name = $name[0];
            }


        return $this->render('index',['models'=>$models,'pagelation'=>$pagelation,'search'=>$search]);
 }

    public function actionAdd()
    {
        $model=new Goods();
        $info=new GoodsIntro();
        $goodscount=new GoodsCount();
        if($model->load(\Yii::$app->request->post()) && $info->load(\Yii::$app->request->post()) && $model->validate() && $info->validate()){
//            var_dump($model->load(\Yii::$app->request->post()));exit;
            $date=GoodsCount::findOne(['day'=>date('Ymd')]);
            if($date==null){
                $goodscount->day=date('Ymd');
                $goodscount->count=0;
                $goodscount->save();
            }else{
                $count=($date->count)+1;
                $model->sn=date('Ymd').str_pad($count,5,'0',STR_PAD_LEFT);
                if($model->save(false)){
                    $info->goods_id=$model->id;
                    $info->save(false);
                    $date->count=$date->count + 1;
                    $date->save(false);
                    \Yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect(['goods/index']);
                }else{

                }
            }

        }else{
//           var_dump($info->getErrors(),$model->getErrors());exit;
        }

        $brands=Brand::find()->all();
        $brands=ArrayHelper::map($brands,'id','name');
        $categories=GoodsCategory::find()->all();
        return $this->render('add',['model'=>$model,'info'=>$info,'brands'=>$brands,'categories'=>$categories]);
    }
    public function actionEdit($id)
    {
        $model=Goods::findOne(['id'=>$id]);
        $info=GoodsIntro::findOne(['goods_id'=>$id]);
        if($model->load(\Yii::$app->request->post()) && $info->load(\Yii::$app->request->post()) && $model->validate() && $info->validate()){

                if($model->save()){
                    $info->goods_id=$model->id;
                    $info->save();
                    \Yii::$app->session->setFlash('success','修改成功');
                    return $this->redirect(['goods/index']);
                }else{
                    var_dump($info->getErrors(),$model->getErrors());exit;
                }
            }

        $brands=Brand::find()->all();
        $brands=ArrayHelper::map($brands,'id','name');
        $categories=GoodsCategory::find()->all();
        return $this->render('add',['model'=>$model,'info'=>$info,'brands'=>$brands,'categories'=>$categories]);
    }
    public  function actionDel($id){
        $model=Goods::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        \Yii::$app->session->setFlash('success','删除商品成功');
        return $this->redirect(['goods/index']);
    }
//配置文件接收
//配置文件接收
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
                    'extensions' => ['jpg', 'png','gif'],
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
    //配置文件结束
    //配置文件结束
    public function actionPic($id){
            $model=Goods::findOne(['id'=>$id]);
        $goodsimg=new Goodsimg();

        return $this->render('pic', ['model'=>$model,'goodsimg'=>$goodsimg,'id' => $model->id,]);

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
    public function actionTest(){
$cl = new SphinxClient();
$cl->SetServer ( '127.0.0.1', 9312);
$cl->SetConnectTimeout ( 10 );
$cl->SetArrayResult ( true );
$cl->SetMatchMode ( SPH_MATCH_EXTENDED2);
$cl->SetLimits(0, 1000);
$info = '小米电视';
$res = $cl->Query($info, 'goods');//shopstore_search
var_dump($res);
    }
}
