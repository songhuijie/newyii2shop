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
    //每列都有搜索框 控制器传过来$searchModel = new ArticleSearch();
    //'filterModel' => $searchModel,
    'layout'=> '{items}<div class="text-right tooltip-demo">{pager}</div>',
    'pager'=>[
        //'options'=>['class'=>'hidden']//关闭自带分页
        'firstPageLabel'=>"首页",
        'prevPageLabel'=>'上一页',
        'nextPageLabel'=>'下一页',
        'lastPageLabel'=>'尾页',
    ],
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],//序列号从1开始
        // 数据提供者中所含数据所定义的简单的列
        // 使用的是模型的列的数据
        ['label'=>'商品名称','value' => 'name' ],
        ['label'=>'商品编号','value' => 'sn'],
        // 更复杂的列数据
        ['label'=>'图片','format'=>'raw','value'=>function($m){
            return \yii\bootstrap\Html::img($m->logo,['class' => 'img-circle','width' => 30]);
        }],
        ['label'=>'所属分类','value' => 'goodscate.name'],
        ['label'=>'所属商品','value' => 'brand.name'],
        ['label'=>'市场售价','value' => 'market_price'],
        ['label'=>'实际价格','value' => 'shop_price'],
        ['label'=>'库存','value' => 'stock'],
        ['label'=>'是否在售','value' => function($m){return \backend\models\Goods::$saleoptios [$m->is_on_sale]; }],
        ['label'=>'状态','value' => function($m){return \backend\models\Goods::$statusoptios [$m->status]; }],
        ['label'=>'排序','value' => 'sort'],
        ['label'=>'发布日期','format' => ['date', 'php:Y-m-d'],'value' => 'create_time'],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{delete} {update}',//只需要展示删除和更新
            /*'headerOptions' => ['width' => '80'],*/
            'buttons' => [
                'delete' => function($url, $model, $key){
                    return \yii\bootstrap\Html::a('<i class="glyphicon glyphicon-trash"></i> 删除',
                        ['artdel', 'id' => $key],
                        ['class' => 'btn btn-default btn-xs',
                            'data' => ['confirm' => '你确定要删除文章吗？',]
                        ]);
                },
                'update' => function($url, $model, $key){
                    return \yii\bootstrap\Html::a('<i class="fa fa-file"></i> 更新',
                        ['artedit', 'id' => $key],
                        ['class' => 'btn btn-default btn-xs']);
                },
            ],
        ],
    ],
]);
?>
