<?php
namespace frontend\models;
use yii\base\Model;

class Login extends Model{
    public $username;
    public $password;
    public $code;
    public $rememberMe;
    public function rules()
    {
        return [
            [['username','password','code'],'required','message'=>'不能为空'],//不能为空
            [['rememberMe'],'safe'],//安全
        ];
    }
    public function attributeLabels()
    {
        return [
            'username'=>'用户名：',
            'password'=>'密码：',
            'code'=>'验证码：',
            'rememberMe'=>'保存登录信息',
        ];
    }
    public function login($model){
        $member=Member::findOne(['username'=>$model->username]);
        if(!$member){
            $this->addError('username','用户名错误');
            return false;
        }else{
            if(!\Yii::$app->security->validatePassword($model->password,$member->password_hash)){
                $this->addError('password','密码错误');
                return false;
            }else{
                $member->last_login_ip=ip2long(\Yii::$app->request->getUserIP());
                //将ip地址保存为int类型  ip2long()   将int类型ip地址转换为正常long2ip()
                $member->last_login_time=time();
                $member->save(false);
                if($model->rememberMe==1){
                    $cookie=\Yii::$app->user->authTimeout;
                    \Yii::$app->user->login($member,$cookie);
                    return true;
                }else{
                    \Yii::$app->user->login($member);
                }
                return true;
            }
        }
    }
}