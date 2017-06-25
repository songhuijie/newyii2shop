<?php
use light\assets\LayerAsset;
LayerAsset::register($this);

use yii\bootstrap\Modal;
use yii\bootstrap\Alert;
?>



<table class="table table-bordered table-striped">
    <tr>
        <td>ID</td>
        <td>商品名称</td>
        <td>简介</td>
        <td>图片</td>
        <td>排序</td>
        <td>状态</td>
        <td>操作</td>
    </tr>
    <?php foreach($model as $m):?>
    <tr>
        <td><?=$m->id?></td>
        <td><?=$m->name?></td>
        <td><?=$m->intro?></td>

        <td><?=\yii\bootstrap\Html::img($m->qnurl,['width'=>'50px'])?></td>
        <td><?=$m->sort?></td>
        <td><?=\backend\models\Brand::$stausoptions[$m->status]?></td>
        <td>
              <?php if(\Yii::$app->user->can('brand/edit'))echo \yii\bootstrap\Html::a('<span class="glyphicon glyphicon-pencil">',['brand/edit','id'=>$m->id],['class'=>'btn btn-primary btn-xs']);?>
            <?php if(\Yii::$app->user->can('brand/del'))echo \yii\bootstrap\Html::a('<span class="glyphicon glyphicon-trash del">','javascript:;',['class'=>'btn btn-danger btn-xs'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>

<?php
/*echo \yii\bootstrap\Html::a('创建', '#', [
    'id' => 'create',
    'data-toggle' => 'modal',
    'data-target' => '#create-modal',
    'class' => 'btn btn-success',
]);*/
echo \yii\widgets\LinkPager::widget(
        [ 'pagination'=>$pagelation,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
    'firstPageLabel'=>'首页',
    'lastPageLabel'=>'末页',
    'options'=>['class'=>'pagination','style'=>'padding-left:30%'],
]);
?>

<?php

$js=<<<JS
 
    $('.del').on('click',function(){
        var node=$(this).closest('tr');
        var id=$(this).closest('tr').find('td:first').html();
       layer.confirm('确定要删除吗？',{icon:3, title:'提示'},function(){
           $.ajax({
       url: 'ajaxdel',
       type: 'get',
       data: {'id':id},
       success: function (data) {
          if(data.search){
              layer.msg('删除成功');
              node.remove();
          }
       }
  });
       });
      
        
    })
JS;
$this->registerJs($js);







