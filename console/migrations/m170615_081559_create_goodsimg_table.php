<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goodsimg`.
 */
class m170615_081559_create_goodsimg_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goodsimg', [
            'id' => $this->primaryKey(),
            'goods_id'=> $this->integer(11)->notNull(),
            'img'=>$this->string(50)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goodsimg');
    }
}
