<?php
use light\assets\LayerAsset;
LayerAsset::register($this);

$form=\yii\bootstrap\ActiveForm::begin(['layout' => 'horizontal']);
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();

//echo $form->field($model,'imgFile')->fileInput();
echo '<div style="margin-left: 230px">';

echo '<strong>请选择logo</strong>'.\yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo $form->field($model,'logo')->hiddenInput(['id'=>'filename'])->label('');
echo $form->field($model,'qnurl')->hiddenInput(['id'=>'qnurl'])->label('');
echo \xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new \yii\web\JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}

EOF
        ),
        'onUploadSuccess' => new \yii\web\JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        
        console.log(data.fileUrl);
        $('#logo').attr('src',data.fileUrl[0]).show();
        $('#filename').val(data.fileUrl[1]);
        $('#qnurl').val(data.fileUrl[0]);
        layer.msg('成功');
        
    }
}
EOF
        ),
    ]
]);



if($model->logo){
    echo \yii\bootstrap\Html::img('',['id'=>'logo','height'=>50,'margin'=>'10px']);
}else{
    echo \yii\bootstrap\Html::img('',['id'=>'logo','style'=>'display:none','height'=>50,'margin'=>'10px']);
}
echo '</div>';
echo $form->field($model,'sort');

echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Brand::$stausoptions);
echo \yii\bootstrap\Html::submitButton($sub,['class'=>'btn btn-info col-lg-offset-8']);
\yii\bootstrap\ActiveForm::end();