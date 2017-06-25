<?php
namespace frontend\models;
use yii\base\Model;

class  PasswordForm extends Model{
    public $id;
    public $password;
    public $repassword;
    public function rules()
    {
        return [
            [['id','password', 'repassword'], 'required','message'=>'不能为空'],
            [['password'], 'string', 'min' => 4,'tooShort'=>'密码长度最少4位'],
            [['repassword'], 'compare', 'compareAttribute'=>'password','message'=>'2次密码输入不一致'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id'=>'',
            'password'=>'密码：',
            'repassword'=>'确认密码：',
        ];
    }
    public function reload($model){
        $member=Member::findOne(['id'=>$model->id]);
        if($member){
            $member->password_hash='';
            $member->password_hash=\Yii::$app->security->generatePasswordHash($model->password);
            $member->save(false);
            return true;
        }
    }
}