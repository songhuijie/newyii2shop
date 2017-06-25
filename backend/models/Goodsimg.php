<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goodsimg".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property string $img
 */
class Goodsimg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $imgfile;
    public static function tableName()
    {
        return 'goodsimg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['id', 'goods_id', 'img'], 'required'],
//            [['id', 'goods_id'], 'integer'],
            [['img'], 'string', 'max' => 255],
            [['goodsimg'], 'file', 'extensions'=>['gif','jpg','png']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品表ID',
            'img' => '图片',
            'imgfile' => '详细图',
        ];
    }
}
