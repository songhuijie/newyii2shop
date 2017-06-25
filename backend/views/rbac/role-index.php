<table class="table table-bordered table-striped">
    <tr>
        <th>名称</th>
        <th>描述</th>
        <th>权限</th>
        <th>操作</th>
    </tr>
    <?php foreach ($roles as $role):?>
        <tr>
            <td><?=$role->name?></td>
            <td><?=$role->description?></td>
            <td><?php
                if(\Yii::$app->authManager->getPermissionsByRole($role->name)){
                    foreach(\Yii::$app->authManager->getPermissionsByRole($role->name) as $permission){
                        echo $permission->description;
                        echo ',';
                    }
                }
                ?></td>
            <td>
                <?php if(\Yii::$app->user->can('rbac/del-role'))echo\yii\bootstrap\Html::a('删除',['rbac/del-role','name'=>$role->name],['class'=>'btn btn-danger btn-xs'])?>
                <?php if(\Yii::$app->user->can('rbac/edit-role'))echo\yii\bootstrap\Html::a('修改',['rbac/edit-role','name'=>$role->name],['class'=>'btn btn-info btn-xs'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
