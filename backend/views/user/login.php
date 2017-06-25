<?php
$from=\yii\bootstrap\ActiveForm::begin(['layout' => 'horizontal']);
echo $from->field($model,'username');
echo $from->field($model,'password')->passwordInput();
echo $from->field($model,'cookie')->checkboxList([1=>'记住密码'])->label('');
echo \yii\bootstrap\Html::submitButton('登录',['class'=>'btn btn-info col-lg-offset-8']);
\yii\bootstrap\ActiveForm::end();