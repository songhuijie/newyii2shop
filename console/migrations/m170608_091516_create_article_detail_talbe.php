<?php

use yii\db\Migration;

class m170608_091516_create_article_detail_talbe extends Migration
{
    //            article_detail 文章详情
    //字段名 类型 注释
    public function up()
    {
        $this->createTable('article_detail', [
//article_id primaryKey 文章id
        'article_id'=>$this->primaryKey()->comment('ID'),
//content text 简介
        'content'=>$this->text()->comment('简介'),
        ]);
        $this->addForeignKey('foreign001','article_detail','article_id','acticle','id','CASCADE','RESTRICT');
    }

    public function down()
    {
        echo "m170608_091516_create_article_detail_talbe cannot be reverted.\n";

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
