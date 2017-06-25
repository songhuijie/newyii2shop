<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $name
 * @property string $tel
 * @property integer $member_id
 * @property string $address
 * @property integer $status
 * @property string $province
 * @property string $city
 * @property string $area
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'tel', 'member_id', 'address'], 'required','message'=>'不能为空'],
            [['member_id','status'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['tel'], 'string', 'max' => 11],
            [['address'], 'string', 'max' => 99],
            [['province','city','area','status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '',
            'name' => '收货人',
            'tel' => '电话号码',
            'member_id' => '',
            'address' => '详细地址',
            'status' => '',
            'province' => '省',
            'city' => '市',
            'area' => '区',
        ];
    }
}
