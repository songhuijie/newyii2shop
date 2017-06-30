<?php
$form = \yii\bootstrap\ActiveForm::begin([
    'method' => 'get',
    //get方式提交,需要显式指定action
    'action'=>\yii\helpers\Url::to(['goods/index']),
    'options'=>['class'=>'form-inline']
]);
echo $form->field($search,'name')->textInput(['placeholder'=>'商品名','name'=>'keyword'])->label(false);
echo $form->field($search,'sn')->textInput(['placeholder'=>'货号'])->label(false);
echo $form->field($search,'minPrice')->textInput(['placeholder'=>'￥'])->label(false);
echo $form->field($search,'maxPrice')->textInput(['placeholder'=>'￥'])->label('-');
echo \yii\bootstrap\Html::submitButton('搜索',['class'=>'btn btn-default']);
\yii\bootstrap\ActiveForm::end();
?>

<table class="table table-bordered table-striped">
    <tr>
        <td>ID</td>
        <td>商品名称</td>
        <td>编号</td>
        <td>图片</td>
        <td>所属分类</td>
        <td>所属商品</td>
        <td>市场售价</td>
        <td>实际价格</td>
        <td>库存</td>
        <td>是否在售</td>
        <td>状态</td>
        <td>排序</td>
        <td>添加时间</td>
        <td>操作</td>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->name?></td>
            <td><?=$model->sn?></td>
            <td><?=$model->logo? \yii\bootstrap\Html::img($model->logo,['width'=>50]):''?></td>
            <td><?=$model->goodscate->name?></td>
            <td><?=$model->brand->name?></td>
            <td><?=$model->market_price?></td>
            <td><?=$model->shop_price?></td>
            <td><?=$model->stock?></td>
            <td><?=\backend\models\Goods::$saleoptios [$model->is_on_sale]?></td>
            <td><?=\backend\models\Goods::$statusoptios [$model->status]?></td>
            <td><?=$model->sort?></td>
            <td><?=date('Y年m月d日 H时i分s秒',$model->create_time)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('查看','javascript:;',['class'=>'btn btn-warning btn-xs'])?>
                <?php if(\Yii::$app->user->can('goods/edit'))echo\yii\bootstrap\Html::a('<span class="glyphicon glyphicon-pencil">',['goods/edit','id'=>$model->id],['class'=>'btn btn-info btn-xs'])?>
                <?=\yii\bootstrap\Html::a('查看详情图',['photo/index','id'=>$model->id],['class'=>'btn btn-primary btn-xs'])?>
                <?php if(\Yii::$app->user->can('goods/del'))echo\yii\bootstrap\Html::a('<span class="glyphicon glyphicon-trash">',['goods/del','id'=>$model->id],['class'=>'btn btn-danger btn-xs'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php

echo \yii\widgets\LinkPager::widget(
    [ 'pagination'=>$pagelation,
        'nextPageLabel'=>'下一页',
        'prevPageLabel'=>'上一页',
        'firstPageLabel'=>'首页',
        'lastPageLabel'=>'末页',
        'options'=>['class'=>'pagination','style'=>'padding-left:30%'
        ]
]);

