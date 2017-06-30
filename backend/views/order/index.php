<?php
use light\assets\LayerAsset;
LayerAsset::register($this);?>
<table class="table table-bordered table-responsive">
    <tr>
        <td>ID</td>
        <td>订单金额</td>
        <td>下单时间</td>
        <td>订单状态</td>
        <td>操作</td>
    </tr>
    <?php foreach ($orders as $order):?>
        <tr>
            <td><?=$order->id?></td>
            <td>￥<?=$order->total?>  <?=$order->payment_name?></td>
            <td><?=date('Y-d-m H:i:s',$order->create_time)?></td>
            <td><?=\frontend\models\Order::$statuoptins[$order->status]?></td>
            <td>
                <?=\yii\helpers\Html::a('修改订单状态', '#', [
                    'id' => 'create',
                    'data-toggle' => 'modal',
                    'data-target' => '#create-modal',
                    'class' => 'edit btn btn-success btn-xs',
                    'data-id'=>$order->id
                    ])?>
                <?=\yii\helpers\Html::a('查看商品详情',['order/orderinfo','id'=>$order->id],['class' => 'edit btn btn-info btn-xs'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'create-modal',
    'header' => '<h4 class="modal-title">修改订单状态</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
]);
$requestUrl = \yii\helpers\Url::toRoute('create');
$js = <<<JS
$('.edit').on('click',function(){
    var id=$(this).attr('data-id');
    console.log(id);
    $.get('{$requestUrl}', {id:id},function (data) {
        $('.modal-body').html(data);
});
})

JS;
$this->registerJs($js);
\yii\bootstrap\Modal::end();
?>
