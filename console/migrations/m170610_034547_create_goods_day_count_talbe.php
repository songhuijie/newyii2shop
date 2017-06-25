<?php

use yii\db\Migration;

class m170610_034547_create_goods_day_count_talbe extends Migration
{
    /*public function safeUp()
    {


    }

    public function safeDown()
    {
        echo "m170610_034547_create_goods_day_count_talbe cannot be reverted.\n";

        return false;
    }*/


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('goods_day_count', [
//            字段名 类型 注释
//day date 日期
        'day'=>$this->date()->comment('日期'),
//count int 商品数
        'count'=>$this->integer()->comment('商品数'),
        ]);
    }

    public function down()
    {
        echo "m170610_034547_create_goods_day_count_talbe cannot be reverted.\n";

        return false;
    }

}
