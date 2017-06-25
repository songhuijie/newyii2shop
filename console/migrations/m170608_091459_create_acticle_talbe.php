<?php

use yii\db\Migration;

class m170608_091459_create_acticle_talbe extends Migration
{
    public function up()
    {
//        article 文章
//字段名 类型 注释


        $this->createTable('acticle', [
            //id primaryKey
            'id'=>$this->primaryKey()->comment('ID'),
//name varchar﴾50﴿ 名称
            'name'=>$this->string(50)->comment('文章名称'),
//intro text 简介
            'intro'=>$this->text()->comment('文章简介'),
//article_category_id int﴾﴿ 文章分类id
            'article_category_id'=>$this->integer()->comment('排序'),
//sort int﴾11﴿ 排序
            'sort'=>$this->integer()->comment('排序'),
//status int﴾2﴿ 状态﴾‐1删除 0隐藏 1正常﴿
            'status'=>$this->smallInteger()->comment('文章状态'),
//create_time int﴾11﴿ 创建时间
            'create_time'=>$this->integer()->comment('文章类型'),
        ]);
        $this->addForeignKey('foreign002','acticle','article_category_id','acticle_category','id','CASCADE','RESTRICT');
    }

    public function down()
    {
        echo "m170608_091459_create_acticle_talbe cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
