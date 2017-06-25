<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m170619_080007_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(20)->notNull()->comment('收货人'),
            'tel'=>$this->char(11)->notNull()->comment('电话号码'),
            'member_id'=>$this->integer()->notNull()->comment('用户id'),
            'address'=>$this->string(99)->notNull()->comment('详细地址'),
            'status'=>$this->integer(99)->defaultValue(0)->comment('详细地址'),
            'province'=>$this->integer()->notNull()->comment('省'),
            'city'=>$this->integer()->notNull()->comment('市'),
            'area'=>$this->integer()->notNull()->comment('区'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
