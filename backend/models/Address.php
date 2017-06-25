<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $name
 * @property string $tel
 * @property integer $member_id
 * @property string $address
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
            [['name', 'tel', 'member_id', 'address'], 'required'],
            [['member_id'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['tel'], 'string', 'max' => 11],
            [['address'], 'string', 'max' => 99],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '收货人',
            'tel' => '电话号码',
            'member_id' => '用户id',
            'address' => '详细地址',
        ];
    }
}
