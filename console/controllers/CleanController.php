<?php
namespace console\controllers;
use backend\models\Goods;
use frontend\models\Order;
use yii\console\Controller;

class CleanController extends Controller{
    public function actionDel(){
        set_time_limit(0);//设置脚本时间无限执行  默认为30秒 执行完跳过
        //死循环
        while(1){
            //查询出状态为支付 和拍下过了1小时没有支付的订单 然后把状态设置为取消
            $orders=Order::find()->where(['status'=>1])->andWhere(['<','create_time',time()-3600])->all();
            foreach($orders as $order){
                $order->status=0;
                $order->save();
                //因为只有订单详情表才有商品数量 所有一对多的关系建立遍历返回他的库存
                foreach($order->goods as $good){
                    //如果订单过期的话就还原 订单数量到商品的库存 条件就是商品id 相同
                    Goods::updateAllCounters(['stock'=>$good->amount],['id'=>$good->goods_id]);
                    //'id='.$goods->goods_id 第二个参数可以时数组也可以是字符串
                }
                //然后输出商品已经请清除
                echo "ID".$good->id." has been clean...\n";
            }

            sleep(1);//使服务器睡觉1秒
        }
    }
}