<?php
namespace frontend\controllers;
use frontend\models\Address;
use frontend\models\Locations;
use yii\web\Controller;

class AddressController extends Controller{
    public $layout='address.php';
    public function actionAdd(){
        $model=new Address();
        $address=Address::find()->where(['member_id'=>\Yii::$app->user->identity->id])->all();
        $count=1;
        $sub='添加';
        return $this->render('add',['model'=>$model,'address'=>$address,'count'=>$count,'sub'=>$sub]);
    }
    //现在不用数据库的 3级联动城市数据
    public function actionEdit($id){
        $model=Address::findOne(['id'=>$id]);
        $address=Address::find()->where(['member_id'=>\Yii::$app->user->identity->id])->all();
        $count=1;
        $sub='修改';
        return $this->render('add',['model'=>$model,'address'=>$address,'count'=>$count,'sub'=>$sub]);
    }
    public function actionLocations()
    {
        if (\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->get('pid');
            $locations = Locations::find()->asArray()->where(['parent_id' => $id])->all();
//        var_dump($locations);exit;
            $response = \Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $response->data = $locations;
            return $response->send();
        }
    }

    public function actionAddsave(){
        if (\Yii::$app->request->isAjax) {
            $data = \Yii::$app->request->post();

//            var_dump(Locations::findOne(['id'=>$data['area']]));exit;
            $address=new Address();
            if($data['Address']['status']==1){
                $mraddress=Address::find()->where(['member_id'=>$data['Address']['member_id']])->all();
                foreach($mraddress as $a){
                    $a->status=0;
                    $a->save();
                }
            }

            $address->name=$data['Address']['name'];
            $address->member_id=$data['Address']['member_id'];
            $address->tel=$data['Address']['tel'];
            $address->status=$data['Address']['status'];
            $address->province=$data['province'];
            $address->city=$data['city'];
            $address->area=$data['area'];
            $address->address=$data['Address']['address'];
            if($address->save()){
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
    public function actionEditsave(){
        if (\Yii::$app->request->isAjax) {
            $data = \Yii::$app->request->post();

//            var_dump(Locations::findOne(['id'=>$data['area']]));exit;
            $address=Address::findOne(['id'=>$data['Address']['id']]);
            if($data['Address']['status']==1){
                $mraddress=Address::find()->where(['member_id'=>$data['Address']['member_id']])->all();
                foreach($mraddress as $a){
                    $a->status=0;
                    $a->save();
                }
            }

            $address->name=$data['Address']['name'];
            $address->member_id=$data['Address']['member_id'];
            $address->tel=$data['Address']['tel'];
            $address->status=$data['Address']['status'];
            $address->province=$data['province'];
            $address->city=$data['city'];
            $address->area=$data['area'];
            $address->address=$data['Address']['address'];
            if($address->save()){
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
    //删除 地址
    public function actionDel(){
        if(\Yii::$app->request->isAjax) {
            $id = \Yii::$app->request->get('id');

//           var_dump($id);exit;
            $address = Address::findOne(['id' => $id]);
            if ($address->delete()) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'search' => true,
                    'msg' => '删除成功',
                ];
            } else {
                return [
                    'search' => false,
                    'msg' => '删除失败',
                ];
            }
        }
    }
    //设置默认地址
    public function actionDefault(){
        if(\Yii::$app->request->isAjax){
            $id=\Yii::$app->request->get('id');
            $member_id=\Yii::$app->request->get('member_id');
            $defalutaddress=Address::find()->where(['member_id'=>$member_id])->all();
            foreach ($defalutaddress as $defalut){
                $defalut->status=0;
                $defalut->save();
            }
            $address=Address::findOne(['id'=>$id]);
            $address->status=1;
            if ($address->save()) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'search' => true,
                    'msg' => '设置默认地址成功',
                ];
            } else {
                return [
                    'search' => false,
                    'msg' => '设置默认地址失败',
                ];
            }
        }
    }

}