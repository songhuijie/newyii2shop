<table class="table table-bordered table-responsive">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>地址</th>
        <th>上级菜单</th>
        <th>排序</th>
        <th>操作</th>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->label?></td>
            <td><?=$model->url?></td>
            <td><?=($model->parent_id)? $model->children->label:'顶级菜单'?></td>
            <td><?=$model->sort?></td>
            <td>
                <?php if(\Yii::$app->user->can('menu/edit'))echo\yii\helpers\Html::a('修改',['menu/edit','id'=>$model->id],['class'=>'btn btn-info btn-xs'])?>
                <?php if(\Yii::$app->user->can('menu/del'))echo\yii\helpers\Html::a('删除',['menu/del','id'=>$model->id],['class'=>'btn btn-danger btn-xs'])?>
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
