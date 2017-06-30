<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><?=\yii\helpers\Html::img(\Yii::getAlias('@web/images/logo.png'))?></h2>
        <div class="flow fr">
            <ul>
                <li class="cur">1.我的购物车</li>
                <li>2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->
<div class="mycart w990 mt10 bc">
    <h2><span>我的购物车</span></h2>
    <table>
        <thead>
        <tr>
            <th class="col1">商品名称</th>
            <th class="col3">单价</th>
            <th class="col4">数量</th>
            <th class="col5">小计</th>
            <th class="col6">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  foreach($models as $model):?>
        <tr data-goods_id="<?=$model['id']?>">
            <td class="col1"><?=\yii\helpers\Html::img('http://www.yii2shop.cc.cn/'.$model['logo'])?><strong><a href=""><?=$model['name']?></a></strong></td>
            <td class="col3">￥<span><?=$model['shop_price']?></span></td>
            <td class="col4">
                <a href="javascript:;" class="reduce_num"></a>
                <input type="text" name="amount" value="<?=$model['amount']?>" class="amount"/>
                <a href="javascript:;" class="add_num"></a>
            </td>
            <td class="col5">￥<span><?=$model['shop_price']*$model['amount']?></span></td>
            <td class="col6"><a href="javascript:void(0);" class="del_sub">删除</a></td>
        </tr>
        <?php  endforeach;?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="6">购物金额总计： <strong>￥ <span id="total"><?php $zong=0;foreach ($models as $model){  $zong+=$model['shop_price']*$model['amount'];
            } echo $zong;?></span></strong></td>
        </tr>
        </tfoot>
    </table>
    <div class="cart_btn w990 bc mt10">
        <a href="<?=\yii\helpers\Url::to(['index/index'])?>" class="continue">继续购物</a>
        <?=\yii\helpers\Html::a('结算',['pay/information'],['class'=>'checkout'])?>
    </div>
</div>

<?php
/**
 * @var $this \yii\web\View
 * */
$url=\yii\helpers\Url::to('update');
$token=\Yii::$app->request->csrfToken;
$this->registerJs(new \yii\web\JsExpression(
        <<<JS
//购物时删除该商品
 $('.del_sub').click(function(){
     var goods_id=$(this).closest('tr').attr('data-goods_id');
     console.log(goods_id);
     $.post('$url',{goods_id:goods_id,amount:0,"_csrf-frontend":"$token"},function(){});
     $(this).closest('tr').remove();
 })
  $('.reduce_num,.add_num').click(function(){
      var goods_id=$(this).closest('tr').attr('data-goods_id');
      var amount=$(this).parent().find('.amount').val();
       $.post('$url',{goods_id:goods_id,amount:amount,"_csrf-frontend":"$token"},function(){});
  });
 
JS
));
?>
<!-- 主体部分 end -->
