<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $tel
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property double $delivery_price
 * @property integer $payment_id
 * @property string $payment_name
 * @property string $total
 * @property integer $status
 * @property string $trade_no
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static $delivery=[
        ['delivery_id'=>1,'delivery_name'=>'普通快递送货上门','delivery_price'=>10.00,'info'=>'每张订单不满499.00元,运费15.00元, 订单4...'],
        ['delivery_id'=>2,'delivery_name'=>'特快专递','delivery_price'=>40.00,'info'=>'每张订单不满499.00元,运费15.00元, 订单4...'],
        ['delivery_id'=>3,'delivery_name'=>'加急快递送货上门','delivery_price'=>40.00,'info'=>'每张订单不满499.00元,运费15.00元, 订单4...'],
        ['delivery_id'=>4,'delivery_name'=>'平邮','delivery_price'=>10.00,'info'=>'每张订单不满499.00元,运费15.00元, 订单4...']
    ];
    public static $payment=[
        ['payment_id'=>1,'payment_name'=>'货到付款','info'=>'送货上门后再收款，支持现金、POS机刷卡、支票支付'],
        ['payment_id'=>2,'payment_name'=>'在线支付','info'=>'即时到帐，支持绝大数银行借记卡及部分银行信用卡'],
        ['payment_id'=>3,'payment_name'=>'上门自提','info'=>'自提时付款，支持现金、POS刷卡、支票支付'],
        ['payment_id'=>4,'payment_name'=>'邮局汇款','info'=>'通过快钱平台收款 汇款后1-3个工作日到账'],
    ];
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'name', 'province', 'city', 'area', 'address', 'tel', 'delivery_id', 'delivery_name', 'delivery_price', 'payment_id', 'payment_name', 'total', 'status', 'trade_no', 'create_time'], 'required'],
            [['member_id', 'delivery_id', 'payment_id', 'status', 'create_time'], 'integer'],
            [['delivery_price', 'total'], 'number'],
            [['name', 'province', 'city', 'area', 'address'], 'string', 'max' => 20],
            [['tel'], 'string', 'max' => 11],
            [['delivery_name', 'payment_name', 'trade_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '用户id',
            'name' => '收货人',
            'province' => '省',
            'city' => '市',
            'area' => '区',
            'address' => '详细地址',
            'tel' => '电话号码',
            'delivery_id' => '配送方式id',
            'delivery_name' => '配送方式名称',
            'delivery_price' => '配送方式价格',
            'payment_id' => '支付方式id',
            'payment_name' => '支付方式名称',
            'total' => '订单金额',
            'status' => '订单状态',
            'trade_no' => '第三方支付交易号',
            'create_time' => '创建时间',
        ];
    }

    public function reload($post){
//保存数据
        $member_id=\Yii::$app->user->id;
        $delivery_name='';
        $delivery_price='';

        foreach(self::$delivery as $deli){
            if($deli['delivery_id'] == $post['delivery']){

                $delivery_name=$deli['delivery_name'];
                $delivery_price=$deli['delivery_price'];
            }
        }
        $payment_name='';
        foreach(self::$payment as $pay){
            if($pay['payment_id'] == $post['payment']){
                $payment_name=$pay['payment_name'];
            }
        }
        $address=Address::findOne(['id'=>$post['address_id']]);
        $this->member_id=$member_id;
        $this->name=$address->name;
        $this->province=$address->province;
        $this->city=$address->city;
        $this->area=$address->area;
        $this->address=$address->address;
        $this->tel=$address->tel;
        $this->delivery_id=$post['delivery'];
        $this->delivery_name=$delivery_name;
        $this->delivery_price=$delivery_price;
        $this->payment_id=$post['payment'];
        $this->payment_name=$payment_name;
        $this->total=$post['total'];
        $this->status=2;
        $this->trade_no='无';
        $this->create_time=time();
        $this->save();
        //保存order表的信息
    //保存order_goods 的
        $order_goods=new OrderGoods();
        $carts=Cart::findAll(['member_id'=>$member_id]);
        foreach($carts as $cart){
            $order_goods->order_id=$cart->goods->sn;
            $order_goods->member_id=$member_id;
            $order_goods->goods_id=$cart->goods_id;
            $order_goods->goods_name=$cart->goods->name;
            $order_goods->logo=$cart->goods->logo;
            $order_goods->price=$cart->goods->shop_price;
            $order_goods->amount=$cart->amount;
            $order_goods->total=$cart->amount*$cart->goods->shop_price;
//            var_dump($order_goods);exit;
            $order_goods->save(false);
            $order_goods->isNewRecord = true;
            $order_goods->id = null;
            $cart->delete();
        }
    return true;
    }
    //保存之前保存时间
    /*public function beforeSave($insert)
    {
        if($insert){
            $this->create_time=time();
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }*/
}
