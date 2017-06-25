<?php
namespace frontend\models;
use yii\base\Model;

class  RepasswordForm extends Model{
        public $username;
        public $email;
        public function rules()
        {
            return [
                [['username', 'email'], 'required','message'=>'不能为空'],
                [['email'], 'email'],
            ];
        }
        public function attributeLabels()
        {
            return [
                'username'=>'用户名：',
                'email'=>'邮箱：',
            ];
        }

        public function reload($model){
            $member=Member::findOne(['username'=>$model->username,'email'=>$model->email]);
            if($member){
                //调用发送邮件的组件
                $mail= \Yii::$app->mailer->compose();
                //谁发的
                $mail->setFrom('18080952663@163.com');
                //发给谁
                $mail->setTo($model->email);
                //邮箱名称
                $mail->setSubject("修改密码,请勿泄露给他人");
//$mail->setTextBody('zheshisha ');   //发布纯文字文本
                $mail->setHtmlBody("<a href='http://admin.yii2shop.cc.cn/member/password?id=$member->id' style='color:red'>点我修改密码</a>");    //发布可以带html标签的文本
                $mail->send();
                return true;
            }else{
                $this->addError('username','用户名或者邮箱不正确');
            }
        }
}