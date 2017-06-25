<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m170623_075000_create_cart_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cart', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer()->notNull(),
            'amount'=>$this->integer()->notNull(),
            'member_id'=>$this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cart');
    }
}
