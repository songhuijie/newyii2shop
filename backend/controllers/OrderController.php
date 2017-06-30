<?php
namespace backend\controllers;
use frontend\models\Order;
use yii\web\Controller;

class OrderController extends Controller{
    public function actionIndex(){
        $orders=Order::find()->all();
        return $this->render('index',['orders'=>$orders]);
    }
    public function actionCreate()
    {


            $id = \Yii::$app->request->get('id');
            $model = Order::findOne(['id' => $id]);

        if(\Yii::$app->request->isPost){
            $val=\Yii::$app->request->post('val');
            $id=\Yii::$app->request->post('id');
            \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
            $model = Order::findOne(['id' => $id]);
//            var_dump($model);exit;
            $model->status=$val;
             if($model->save()) {
                return ['error'=>1,'msg'=>'修改成功'];
            }else{
                 return ['error'=>0,'msg'=>'修改失败'];
             }

        }

        return $this->renderAjax('add', [
            'model' => $model,
        ]);
    }
    public function actionOrderinfo($id){
        $orders=Order::find()->where(['id'=>$id])->andWhere(['>','status',1])->one();
        $arr=[];
        foreach($orders->goods as $order){
            $arr[]=$order;
        }
        return $this->render('info',['arr'=>$arr]);
    }
}