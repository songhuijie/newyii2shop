<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "acticle".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $article_category_id
 * @property integer $sort
 * @property integer $status
 * @property integer $create_time
 *
 * @property ActicleCategory $articleCategory
 * @property ArticleDetail $articleDetail
 */
class Acticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    static public $statusoptions=[1=>'正常',0=>'隐藏'];
    public function beforeSave($insert)
    {       if($insert){
        $this->create_time=time();
    }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

//    public function behaviors()
//    {
//        return [
//            [
//                'class'=>TimestampBehavior::className(),
//                'attributes'=>[
//                    ActiveRecord::EVENT_BEFORE_INSERT=>['create_time'],
//                ]
//            ]
//        ];
//    }

    public static function tableName()
    {
        return 'acticle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intro'], 'string'],
            [['article_category_id', 'sort', 'status', 'create_time'], 'integer'],
            [['name'], 'string', 'max' => 50],
           // [['article_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActicleCategory::className(), 'targetAttribute' => ['article_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名称',
            'intro' => '文件简介',
            'article_category_id' => '分类ID',
            'sort' => '排序',
            'status' => '状态',
            'create_time' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleCategory()
    {
        return $this->hasOne(ActicleCategory::className(), ['id' => 'article_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleDetail()
    {
        return $this->hasOne(Artdetail::className(), ['article_id' => 'id']);
    }

}
