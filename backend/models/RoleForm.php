<?php
namespace backend\models;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model{
    public $name;
    public $description;
    public $permissions=[];
    public function rules()
    {
        return [
            [['name','description'],'required'],
            ['permissions','safe']
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'角色名称',
            'description'=>'角色详情',
            'permissions'=>'所属权限',
        ];
    }
    public static function getPermissionoptions(){
        $permission=\Yii::$app->authManager->getPermissions();
        return ArrayHelper::map($permission,'name','description');
    }
    //添加角色并关联规则
    public function role(){
        //实例化rbac规则
        $authManager=\Yii::$app->authManager;
        //添加一个用户
        if($authManager->getRole($this->name)!=null){
            $this->addError('name','该角色已存在');
        }else{
            $role=$authManager->createRole($this->name);
            // 给用户下面的属性赋值
            $role->name=$this->name;
            $role->description=$this->description;
            $authManager->add($role);
            //循环得到的多个规则 取出他
            foreach($this->permissions as $name){
// 获取当前值的permission 规则
                $permission=$authManager->getPermission($name);
                if($permission!=null)$authManager->addChild($role,$permission);
            }
            return true;
        }
        return false;

    }
    //重载并显示
    public function reload($role){
        $authManager=\Yii::$app->authManager;
        $this->name=$role->name;
        $this->description=$role->description;
        $permission=$authManager->getPermissionsByRole($role->name);
        foreach($permission as $p){
            $this->permissions[]=$p->name;
        }

    }
    //修改 角色和关联规则
    public function updaterole($role){
        //实例化rbac规则
        $authManager=\Yii::$app->authManager;

            //判断角色可以创建以后
            if($authManager->getRole($this->name) && $this->name != $role->name){
                // 给用户下面的属性赋值
                $this->addError('name','角色已存在');
            }else{
                $role->name=$this->name;
                $role->description=$this->description;
                $authManager->update($role->name,$role);
                //因为角色名更换了 如果该角色管理了很多规则 则需要清除他所有的的所属规则
                $authManager->removeChildren($role);//当前角色
                //循环得到的多个规则 取出他
                foreach($this->permissions as $name){
// 获取当前值的permission 规则
                    $permission=$authManager->getPermission($name);
                    if($permission!=null) $authManager->addChild($role,$permission);
                }
                return true;
            }
            return false;


    }
}