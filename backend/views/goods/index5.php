<?php $form = \yii\bootstrap\ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'id' => 'cateadd-form',
    'options' => ['class' => 'form-horizontal'],
]); ?>
<?= \yii\bootstrap\Html::a('返回首页',['goods/index'], ['class' => 'btn btn-sm btn-primary']) ?>
<?= \yii\bootstrap\Html::a('添加商品',['goods/add'], ['class' => 'btn btn-sm btn-primary']) ?>
<?= $form->field($searchModel, 'name',[
    'options'=>['class'=>''],
    'inputOptions' => ['placeholder' => '文章搜索','class' => 'input-sm form-control','style'=>'width:300px;'],
])->label(false) ?>
<?= \yii\bootstrap\Html::submitButton('搜索', ['class' => 'btn btn-sm btn-primary']) ?>
<?php \yii\bootstrap\ActiveForm::end(); ?>
<?php
use yii\grid\GridView;
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'layout'=> '{items}<div class="text-right tooltip-demo">{pager}</div>',
    'pager'=>[
        'firstPageLabel'=>"首页",
        'prevPageLabel'=>'上一页',
        'nextPageLabel'=>'下一页',
        'lastPageLabel'=>'尾页',
    ],
    'columns' => [
        ['label'=>'商品名', 'value' => 'name' ],
        ['label'=>'货号','value'=>'sn'],
        ['label'=>'品牌','value'=>'brand.name'],
        ['label'=>'分类','value'=>'goodscate.name'],
        ['label'=>'LOGO','format'=>'raw','value'=>function($m){
            return \yii\bootstrap\Html::img($m->logo,['width' => 30]);
        }],
        ['label'=>'市场价格','value'=>'market_price'],
        ['label'=>'商品价格','value'=>'shop_price'],
        ['label'=>'库存','value'=>'stock'],
        ['label'=>'是否上架','value'=>function($m){
            return \backend\models\Goods::$saleoptios[$m->is_on_sale];
        }],
        ['label'=>'状态','value'=>function($m){
            return \backend\models\Goods::$statusoptios[$m->is_on_sale];
        }],
        ['label'=>'添加时间','format' => ['date', 'php:Y-m-d'],'value' => 'create_time'],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{delete} {update}',
            'buttons' => [
                'delete' => function($url, $model, $key){
                    return \yii\bootstrap\Html::a('<i class="glyphicon glyphicon-trash"></i> 删除',
                        ['goods/del', 'id' => $key],
                        ['class' => 'btn btn-default btn-xs',
                            'data' => ['confirm' => '你确定要删除文章吗？',]
                        ]);
                },
                'update' => function($url, $model, $key){
                    return \yii\bootstrap\Html::a('<i class="fa fa-file"></i> 修改',
                        ['goods/edit', 'id' => $key],
                        ['class' => 'btn btn-default btn-xs']);
                },
            ],
        ],
    ],
]);
?>