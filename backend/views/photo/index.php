<table class="table table-bordered table-striped">
    <tr>
        <td>图片</td>
        <td>操作</td>
    </tr>
    <?php foreach($model as $m):?>
    <tr>
        <td><?=\yii\bootstrap\Html::img($m->img,['width'=>60])?></td>
        <td><?=\yii\bootstrap\Html::a('删除',['photo/del','id'=>$m->id],['class'=>'btn btn-danger'])?></td>
    </tr>
    <?php endforeach;?>
</table>
<?php
use kartik\file\FileInput;
////使用ActiveForm的表单
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($modelform, 'imgfile[]')->widget(FileInput::classname(), [
    'options' => ['multiple' => true],

]);
\yii\bootstrap\ActiveForm::end();
echo \yii\widgets\LinkPager::widget(
    [ 'pagination'=>$pagelation,
        'nextPageLabel'=>'下一页',
        'prevPageLabel'=>'上一页',
        'firstPageLabel'=>'首页',
        'lastPageLabel'=>'末页',
        'options'=>['class'=>'pagination','style'=>'padding-left:30%'
        ]
    ]);