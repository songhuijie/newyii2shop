<?php
namespace backend\models;
use Symfony\Component\BrowserKit\Cookie;
use yii\base\Model;

class Login extends Model{
    public $username;
    public $password;
    public $cookie;
    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['password'],'validateNum'],
            [['cookie'],'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'cookie'=>'下次自动登录',
        ];
    }
    public function validateNum(){
        $user=UserBackend::findOne(['username'=>$this->username]);
        if($user){
            if(!\Yii::$app->security->validatePassword($this->password,$user->password_hash)){
                $this->addError('password','用户名或者密码错误');
            }else{
                $user->end_time=time();
                $user->ip_end=\Yii::$app->request->getUserIP();
                $user->save();
                $cookie=\Yii::$app->user->authTimeout;
                \Yii::$app->user->login($user,$this->cookie?$cookie:'');
            }
        }else{
            $this->addError('username','用户名或者密码错误');
        }
    }
}
