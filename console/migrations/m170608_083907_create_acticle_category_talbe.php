<?php

use yii\db\Migration;

class m170608_083907_create_acticle_category_talbe extends Migration
{
    //article_category 文章
    public function up(){
//id primaryKey
        $this->createTable('acticle_category', [
        'id'=>$this->primaryKey()->comment('ID'),
//name varchar﴾50﴿ 名称
        'name'=>$this->string(50)->comment('文章名称'),
//intro text 简介
            'intro'=>$this->text()->comment('文章简介'),
//sort int﴾11﴿ 排序
            'sort'=>$this->integer()->comment('排序'),
//status int﴾2﴿ 状态﴾‐1删除 0隐藏 1正常﴿
            'status'=>$this->smallInteger()->comment('文章状态'),
//is_help int﴾1﴿ 类型
            'is_help'=>$this->smallInteger()->comment('文章类型'),
        ]);
    }

    public function down()
    {
        echo "m170608_083907_create_acticle_category_talbe cannot be reverted.\n";

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
