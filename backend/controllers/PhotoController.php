<?php
namespace backend\controllers;
use backend\filters\UserFilter;
use backend\models\Goodsimg;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;

class PhotoController extends Controller{
    public function actionIndex($id)
    {
        $goods = Goodsimg::find()->where(['goods_id' => $id]);
        $pagelation=new Pagination([
            'totalCount'=>$goods->count(),
            'defaultPageSize'=>3,
        ]);
        $model=$goods->offset($pagelation->offset)->limit($pagelation->limit)->all();

        $modelform = new Goodsimg();
        if ($modelform->load(\Yii::$app->request->post())) {
            $imgObjects = UploadedFile::getInstances($modelform, 'imgfile');
            //分目录存储
            $dirname = '/img/goodsimg/' . date('Y-m-d');
            //判断该目录是否存在
            if (!is_dir(\Yii::getAlias('@webroot') . $dirname)) {
                mkdir(\Yii::getAlias('@webroot') . $dirname, 0777, true);
            }
            foreach ($imgObjects as $file) {
                //保存图片
                //文件名
                $filename = $dirname . '/' . uniqid() . '.' . $file->getExtension();
                //保存
                $file->saveAs(\Yii::getAlias('@webroot') . $filename, false);
                //给图片字段赋值
                $modelform->img = $filename;
                //商品ID
                $modelform->goods_id = $id;
                $modelform->save(false);
                //因为是数组 同时插入多条数据 所以我们保存一次后 要讲这次的id清除 不然下次操作会变成修改
                $modelform->isNewRecord = true;
                $modelform->id = null;
            }
            return $this->redirect(['photo/index', 'id' => $id]);
        };
        return $this->render('index', ['model' => $model,'modelform' => $modelform, 'pagelation' => $pagelation]);
    }
    public function actionDel($id){
        $photo=Goodsimg::findOne(['id'=>$id]);
        $goods_id=$photo->goods_id;
        $photo->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['photo/index','id'=>$goods_id]);
    }
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>UserFilter::className(),
                'only'=>['del','index']
            ]
        ];
    }
}