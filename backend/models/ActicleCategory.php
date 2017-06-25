<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "acticle_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $sort
 * @property integer $status
 * @property integer $is_help
 */
class ActicleCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    static public $statusoptions=[1=>'正常',0=>'隐藏'];
    static public $ishlepoptions=[1=>'帮助类型',0=>'非帮助类型'];
    public static function tableName()
    {
        return 'acticle_category';
    }

    /**
     * @inheritdoc
     */



    public function rules()
    {
        return [
            [['intro','sort','name','status','is_help'],'required'],
            [['intro'], 'string'],
            [['sort', 'status', 'is_help'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章分类名称',
            'intro' => '文章简介',
            'sort' => '排序',
            'status' => '文章状态',
            'is_help' => '是否是帮助文档',
        ];
    }
}
