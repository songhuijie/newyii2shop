<?php

use yii\db\Migration;

class m170610_034615_create_goods_intro_talbe extends Migration
{
    /*public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170610_034615_create_goods_intro_talbe cannot be reverted.\n";

        return false;
    }*/


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('goods_intro', [
//            goods_id int 商品id
        'goods_id'=>$this->integer()->notNull()->comment('商品id'),
//content text 商品描述
        'content'=>$this->text()->comment('商品描述'),
        ]);
    }

    public function down()
    {
        echo "m170610_034615_create_goods_intro_talbe cannot be reverted.\n";

        return false;
    }

}
