<?php
namespace backend\models;
use yii\base\Model;

class PermissionForm extends Model{
    public $name;
    public $description;
    public function rules()
    {
        return [
            [['name','description'],'required'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'名称',
            'description'=>'描述',
        ];
    }
    //添加规则的模型方法
    public function Permission(){
        $authManager=\Yii::$app->authManager;
        //判断如果此规则在数据库存在 则不允许创建
        if($authManager->getPermission($this->name)){
            $this->addError('name','改名称已存在，不能重复创建');
            return false;
        }else{
            $permission=$authManager->createPermission($this->name);
            $permission->description=$this->description;
            return $authManager->add($permission);
        }
        return false;
    }
    // 修改规则的模型方法
    public function updatePermission($permission){
        if($this->name != $permission->name){
            if(\Yii::$app->authManager->getPermission($this->name)){
                $this->addError('name','改名称已存在，不能重复创建');
                return false;
            }
        }else{
            $permission->name=$this->name;
            $permission->description=$this->description;
            return \Yii::$app->authManager->update($permission->name,$permission);
        }
        return false;
    }
    //因为使用的表单模型 所有我们要使用表赋值的方法 让修改可以回显数据
    public function reload($permission){
        $this->name=$permission->name;
        $this->description=$permission->description;
    }
}