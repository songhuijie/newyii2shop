<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $label
 * @property string $url
 * @property integer $parent_id
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label'], 'required'],
            [['parent_id'], 'integer'],
            [['sort'], 'integer'],
            [['label'], 'string', 'max' => 20],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => '名称',
            'url' => '地址/路由',
            'parent_id' => '上级分类',
            'sort' => '排序',
        ];
    }
    //一对一的关系 在首页展示 需要
    public function getChildren(){
        return $this->hasOne(self::className(),['id'=>'parent_id']);
    }
    //一对多的关系  方便使用下面的数据 id与父id的关系
    public function getAllchildren(){
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }
}
