<table class="table table-bordered table-striped">
    <tr>
        <td>ID</td>
        <td>分类名</td>
        <td>所属分类</td>
        <td>操作</td>
    </tr>
    <?php foreach($model as $m):?>
<?php //var_dump($m->goodscategory->name);exit;?>
        <tr>
            <td><?=$m->id?></td>
            <td><?=$m->name?></td>
            <td><?=($m->parent_id==0)? '顶级分类':$m->goodscategory->name;?></td>
            <td>
                <?php if(\Yii::$app->user->can('goods-category/edit'))echo\yii\bootstrap\Html::a('修改',['goods-category/edit','id'=>$m->id],['class'=>'btn btn-primary btn-xs'])?>
                <?php if(\Yii::$app->user->can('goods-category/del'))echo\yii\bootstrap\Html::a('删除',['goods-category/del','id'=>$m->id],['class'=>'btn btn-danger btn-xs'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>