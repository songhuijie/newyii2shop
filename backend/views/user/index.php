<table class="table table-bordered table-striped">
    <tr>
        <td>ID</td>
        <td>用户名</td>
        <td>邮箱</td>
        <td>注册时间</td>
        <td>最后登录时间</td>
        <td>最后登录ip</td>
        <td>当前角色</td>
        <td>操作</td>
    </tr>
    <?php foreach($model as $m):?>
    <tr>
        <td><?=$m->id?></td>
        <td><?=$m->username?></td>
        <td><?=$m->email?></td>
        <td><?=date('Y年m月d日 H:i:s',$m->created_at)?></td>
        <td><?=$m->end_time?date('Y年m月d日 H:i:s',$m->end_time):''?></td>
        <td><?=$m->ip_end?></td>
        <td><?php
            if(\Yii::$app->authManager->getRolesByUser($m->id)){
                foreach(\Yii::$app->authManager->getRolesByUser($m->id) as $role){
                    echo $role->description;
                    echo ' ';
                }
            }
            ?></td>
        <td>
            <?php if(\Yii::$app->user->can('user/edit'))echo\yii\bootstrap\Html::a('<span class="glyphicon glyphicon-pencil"></span>',['user/edit','id'=>$m->id],['class'=>'btn btn-info btn-xs'])?>
            <?php if(\Yii::$app->user->can('user/del'))echo\yii\bootstrap\Html::a('<span class="glyphicon glyphicon-trash"></span>',['user/del','id'=>$m->id],['class'=>'btn btn-danger btn-xs'])?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
