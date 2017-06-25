<table class="table table-bordered table-hover table-striped table-condensed table-responsive">
    <tr>
        <td>ID</td>
        <td>名称</td>
        <td>操作</td>
    </tr>
    <?php foreach($models as $model):?>
        <tr data-lft="<?=$model->lft?>" data-rgt="<?=$model->rgt?>" data-tree="<?=$model->tree?>" data-depth="<?=$model->depth?>">
            <td><?=$model->id?></td>
            <td><?=str_repeat('- - -',$model->depth).$model->name?><span class="xian glyphicon glyphicon-chevron-down" style="float: right"></span></td>
            <td>修改 删除</td>
        </tr>
    <?php endforeach;?>
</table>
<?php

$js=<<<JS
    $('.xian').click(function(){
        var node=$(this).closest('tr');
       var lft= parseInt(node.attr('data-lft'));
       var rgt= parseInt(node.attr('data-rgt'));
       var tree= parseInt(node.attr('data-tree'));
        var show = $(this).hasClass('glyphicon-chevron-up');
        $(this).toggleClass('glyphicon glyphicon-chevron-down');
        $(this).toggleClass('glyphicon glyphicon-chevron-up');
        
        $("table tr").each(function () {
            
            //查找当前分类的子孙分类（根据当前的tree lft rgt）
            //同一颗树  左值大于lft  右值小于rgt
            
            if(parseInt($(this).attr('data-tree'))==tree && parseInt($(this).attr('data-lft'))>lft && parseInt($(this).attr('data-rgt'))<rgt){
                show?$(this).fadeIn():$(this).fadeOut();
                
            }
        });
    })
JS;
$this->registerJs($js);

