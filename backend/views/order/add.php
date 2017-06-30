<?php
use light\assets\LayerAsset;
LayerAsset::register($this);
$form=\yii\bootstrap\ActiveForm::begin(['layout' => 'horizontal','id'=>'form']);
echo $form->field($model,'id')->hiddenInput(['class'=>'order_id']);
echo $form->field($model,'status',['inline'=>true])->radioList(\frontend\models\Order::$statuoptins,['option'=>['class'=>'status']]);
echo \yii\bootstrap\Html::button('提交',['id'=>'submit-btn','class'=>' btn btn-info col-lg-offset-8']);
$requestUrl = \yii\helpers\Url::toRoute('create');
$token=\Yii::$app->request->csrfToken;
$js=<<<EOF
    $('#submit-btn').click(function() {
    var val=$('input[name="Order[status]"]:checked ').val();
    var id=$('.order_id').val();
    console.log(val)
    $.post('{$requestUrl}',{val:val,id:id,"_csrf-frontend":"$token"},function(data) {
            layer.msg(data.msg);
          
            location.reload();
            if(data.error == 0){
                location.reload();
            }
        });
    });
EOF;
$this->registerJs($js);