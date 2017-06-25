<?php
$form=\yii\bootstrap\ActiveForm::begin(['layout' => 'horizontal']);
echo $form->field($model,'name');
echo $form->field($model,'description')->textarea();
echo \yii\bootstrap\Html::submitButton($sub,['class'=>'btn btn-info col-lg-offset-8']);
\yii\bootstrap\ActiveForm::end();