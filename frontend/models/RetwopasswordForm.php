<?php
namespace frontend\models;
use yii\base\Model;

class RetwopasswordForm extends Model {
    public $old_password;
    public $new_password;
    public $new2_password;
    public function rules()
    {
        return [
            [['old_password', 'new_password','new2_password'], 'required','message'=>'不能为空'],
            [['new2_password'], 'compare', 'compareAttribute'=>'new_password','message'=>'2次密码输入不一致']
        ];
    }

}