
<?php
$form=\yii\bootstrap\ActiveForm::begin(['layout' => 'horizontal']);
echo $form->field($model,'old_password')->passwordInput();
echo $form->field($model,'new_password')->passwordInput();
echo $form->field($model,'new2_password')->passwordInput();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info col-lg-offset-8']);
\yii\bootstrap\ActiveForm::end();
