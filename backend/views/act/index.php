<?php
use yii\bootstrap\Modal;

/*<?=\yii\bootstrap\Html::a('修改','javasrcipt:;',[
    'id'=>'update',
    'data-toggle' => 'modal',
    'data-target' => '#create-modal2',
    'class'=>'btn btn-primary btn-xs'])*/
?>

<table class="table table-bordered table-striped table-hover">
    <tr>
        <td>ID</td>
        <td>文章名称</td>
        <td>简介</td>
        <td>所属分类</td>
        <td>排序</td>
        <td>状态</td>
        <td>内容</td>
        <td>创建时间</td>
        <td>操作</td>
    </tr>
    <?php foreach($model as $m):?>
        <tr>
            <td><?=$m->id?></td>
            <td><?=$m->name?></td>
            <td><?=$m->intro?></td>
            <td><?=$m->articleCategory->name?></td>
            <td><?=$m->sort?></td>
            <td><?=\backend\models\Acticle::$statusoptions[$m->status]?></td>
<!--  mb_substr($m->articleDetail->content,0,10,'utf-8')          -->
            <td><?=$m->articleDetail->content?></td>
            <td><?=date('Y年m月d日 H:i:s',$m->create_time)?></td>
            <td>
                <?=\yii\bootstrap\Html::a('查看', 'javasrcipt:;',['id' => 'create',
                    'data-toggle' => 'modal',
                    'data-target' => '#create-modal',
                    'class' => 'btn btn-success btn-xs'])?>

                <?php if(\Yii::$app->user->can('act/edit'))echo\yii\bootstrap\Html::a('<span class="glyphicon glyphicon-pencil">',['act/edit','id'=>$m->id],['class'=>'btn btn-info btn-xs'])?>
                <?php if(\Yii::$app->user->can('act/del'))echo\yii\bootstrap\Html::a('<span class="glyphicon glyphicon-trash">',['act/del','id'=>$m->id],['class'=>'btn btn-danger btn-xs'])?>
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

//展示
Modal::begin([
    'id' => 'create-modal',
    'header' => '<h4 class="modal-title">查看内容</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
    'options'=>[
        'data-backdrop'=>'static',//点击空白处不关闭弹窗
        'data-keyboard'=>false,
    ],
]);
$requestUrl = \yii\helpers\Url::toRoute('info');
$js = <<<JS
   $('#create').on('click',function() {
     console.debug($(this));
   })
JS;
$this->registerJs($js);
Modal::end();

//修改
//修改
//修改
/*Modal::begin([
    'id' => 'create-modal2',
    'header' => '<h4 class="modal-title">修改内容</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
    'options'=>[
        'data-backdrop'=>'static',//点击空白处不关闭弹窗
        'data-keyboard'=>false,
    ],
]);
$requestUrl = \yii\helpers\Url::toRoute('update');
$js = <<<JS
    $.get('{$requestUrl}', {},
        function (data) {
            $('.modal-body').html(data);
        }  
    );
JS;
$this->registerJs($js);
Modal::end();*/
?>


