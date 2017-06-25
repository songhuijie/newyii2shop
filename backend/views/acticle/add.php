<?php
use light\assets\LayerAsset;
LayerAsset::register($this);
$form=\yii\bootstrap\ActiveForm::begin(['layout' => 'horizontal','id'=>'form']);
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'sort');
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\ActicleCategory::$statusoptions);
echo $form->field($model,'is_help',['inline'=>true])->radioList(\backend\models\ActicleCategory::$ishlepoptions);
//echo \yii\bootstrap\Html::submitButton('添加',['class'=>'btn btn-info col-lg-offset-8']);
echo \yii\bootstrap\Html::button('添加',['id'=>'submit-btn','class'=>' btn btn-info col-lg-offset-8']);
\yii\bootstrap\ActiveForm::end();
$requestUrl = \yii\helpers\Url::toRoute('create');
$js=<<<EOF
    $('#submit-btn').click(function() {
    $.post('{$requestUrl}',$('#form').serialize(),function(data) {
            layer.msg(data.msg);
            location.reload();
            if(data.error == 0){
                location.reload();
            }
        });
    });
EOF;
$this->registerJs($js);


