<?php

use yii\db\Migration;

class m170610_034559_create_goods_talbe extends Migration
{
    /*public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170610_034559_create_goods_talbe cannot be reverted.\n";

        return false;
    }*/


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('goods', [
//            id primaryKey
        'id'=>$this->primaryKey(),
//name varchar﴾20﴿ 商品名称
        'name'=>$this->string(20)->notNull()->comment('商品名称'),
//sn varchar﴾20﴿ 货号
            'sn'=>$this->string(20)->notNull()->comment('货号'),
//logo varchar﴾255﴿ LOGO图片
            'logo'=>$this->string(255)->comment('LOGO图片'),
//goods_category_id int 商品分类id
            'goods_category_id'=>$this->integer()->notNull()->comment('商品分类id'),
//brand_id int 品牌分类
            'brand_id'=>$this->integer()->notNull()->comment('品牌分类'),
//market_price decimal﴾10,2﴿ 市场价格
            'market_price'=>$this->decimal(10,2)->notNull()->comment('市场价格'),
//shop_price decimal﴾10, 2﴿ 商品价格
            'shop_price'=>$this->decimal(10,2)->notNull()->comment('商品价格'),
//stock int 库存
            'stock'=>$this->integer()->notNull()->comment('库存'),
//            is_on_sale int﴾1﴿ 是否在售﴾1在售 0下架﴿
            'is_on_sale'=>$this->integer()->notNull()->comment('是否在售'),
//status inter﴾1﴿ 状态﴾1正常 0回收站﴿
            'status'=>$this->integer()->notNull()->comment('状态'),
//sort int﴾﴿ 排序
            'sort'=>$this->integer()->notNull()->comment('排序'),
//create_time int﴾﴿ 添加时间
            'create_time'=>$this->integer()->notNull()->comment('添加时间'),
        ]);
    }

    public function down()
    {
        echo "m170610_034559_create_goods_talbe cannot be reverted.\n";

        return false;
    }

}
