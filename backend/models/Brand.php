<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "Brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $status
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     *
     */
//    public $imgFile;
    static public $stausoptions=[1=>'正常',0=>'隐藏'];
    public static function tableName()
    {
        return 'Brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','intro'], 'required'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255],
            [['qnurl'], 'string', 'max' => 255],
//            ['imgFile','file','extensions'=>['gif','jpg','png']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'intro' => '简介',
            'logo' => '图片上传',
            'sort' => '排序',
            'status' => '状态',
        ];
    }

}
