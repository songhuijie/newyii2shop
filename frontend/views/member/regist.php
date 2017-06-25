<?php
use light\assets\LayerAsset;
LayerAsset::register($this);

?>
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $form=\yii\widgets\ActiveForm::begin( [
                            'fieldConfig'=>[
                                    'options'=>['tag'=>'li'],
                                    'errorOptions'=>[ 'tag' => 'p','style'=>'color:red;padding-left:100px']
                            ]
             ]);
            echo '<ul>';
            echo $form->field($model,'username')->textInput(['class'=>'txt']);
            echo $form->field($model,'password')->passwordInput(['class'=>'txt']);
            echo $form->field($model,'repassword')->passwordInput(['class'=>'txt']);
            echo $form->field($model,'email')->textInput(['class'=>'txt']);
            echo $form->field($model,'tel')->textInput(['class'=>'txt']);
            $button='<input type="button" id="Sms_btn" value="发送短信验证"  style="height: 30px"/>';
            echo $form->field($model,'smsCode',['options'=>['class'=>'checkcode'],'template' => "{label}\n{input}$button\n{hint}\n{error}"])->textInput();
            echo $form->field($model,'code',['options'=>['class'=>'checkcode']])->widget(\yii\captcha\Captcha::className(),['template'=>'{input} {image}']);
            echo '<li>
						<label for="">&nbsp;</label>
						<input type="checkbox" class="chb"  id="checkedbox"/> 我已阅读并同意《用户注册协议》
					</li>';
            echo '<li>
                        <label for="">&nbsp;</label>
                        <input id="loginbtn" disabled="disabled" type="submit" value="" class="login_btn">
                    </li>';
            echo '</ul>';
            \yii\widgets\ActiveForm::end();
            ?>

    </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>
    </div>
</div>
<?php

/* @var $this \yii\web\View*/
$url=\yii\helpers\Url::to('send-sms');
$this->registerJs(new \yii\web\JsExpression(
        <<<JS
$('#Sms_btn').click(function(){
    var tel=$('#member-tel').val()
    $.post('$url',{tel:tel},function(data){
        console.log(data.code)
        if(data.search){
            layer.msg(data.msg);
                   var time=60;
                var interval = setInterval(function(){
                    time--;
                    if(time<=0){
                        clearInterval(interval);
                        var html = '获取验证码';
                        $('#Sms_btn').prop('disabled',false);
                    } else{
                        var html = time + ' 秒后再次获取';
                        $('#Sms_btn').prop('disabled',true);
                    }
                    
                    $('#Sms_btn').val(html);
                },1000);
               
        }else{
            layer.msg(data.msg);
            
        }
})
})
JS
));
$js=<<<JS
$('#checkedbox').click(function(){
     var check=$('#checkedbox').prop("checked");
    if(!check){
        $('#loginbtn').prop('disabled',true)
    }else{
        $('#loginbtn').prop('disabled',false)
    }
})
JS;
$this->registerJs($js);
?>