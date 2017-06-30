<?php
use light\assets\LayerAsset;
LayerAsset::register($this);
echo \yii\bootstrap\Html::a('添加分类', '#', [
    'id' => 'create',
    'data-toggle' => 'modal',
    'data-target' => '#create-modal',
    'class' => 'btn btn-success',
]);

\yii\bootstrap\Modal::begin([
    'id' => 'create-modal',
    'header' => '<h4 class="modal-title">添加分类</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
]);
$requestUrl = \yii\helpers\Url::toRoute('edit');
$js = <<<JS

$.get('{$requestUrl}', {},function (data) {
        $('.modal-body').html(data);
});
$('#submit-btn').on('click',function() {
      $.post('{$requestUrl}',$('#form').serialize(),function(data) {
        layer.msg(data.msg);
        if(data.error == 0){
            location.reload();
        }
      });
});
JS;
$this->registerJs($js);
\yii\bootstrap\Modal::end();

?>
<table class="table table-bordered table-striped">
    <tr>
        <td>ID</td>
        <td>文章分类名称</td>
        <td>简介</td>
        <td>排序</td>
        <td>状态</td>
        <td>是否是帮助文档</td>
        <td>操作</td>
    </tr>
    <?php foreach($model as $m):?>
        <tr>
            <td><?=$m->id?></td>
            <td><?=$m->name?></td>
            <td><?=$m->intro?></td>
            <td><?=$m->sort?></td>
            <td><?=\backend\models\ActicleCategory::$statusoptions[$m->status]?></td>
            <td><?=\backend\models\ActicleCategory::$ishlepoptions[$m->is_help]?></td>
            <td>
                <?=\yii\bootstrap\Html::a('查看',null,['class'=>'btn btn-info btn-xs'])?>
                <?php if(\Yii::$app->user->can('acticle/edit'))echo\yii\bootstrap\Html::a('<span class="glyphicon glyphicon-pencil"></span>',['acticle/edit','id'=>$m->id],['class'=>'btn btn-primary btn-xs'])?>
                <?php if(\Yii::$app->user->can('acticle/del'))echo\yii\bootstrap\Html::a('<span class="glyphicon glyphicon-trash"></span>',['acticle/del','id'=>$m->id],['class'=>'btn btn-danger btn-xs'])?>
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
        'options'=>['class'=>'pagination','style'=>'padding-left:30%'],
    ]);