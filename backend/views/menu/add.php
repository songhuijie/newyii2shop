<?php
$form=\yii\bootstrap\ActiveForm::begin(['layout' => 'horizontal']);
echo $form->field($model,'label');
echo $form->field($model,'url');
// ['prompt' => '>>>请选择url<<<'] 可以使用 prompt 使用顶级分类
echo $form->field($model,'parent_id')->dropDownList($parent);
echo $form->field($model,'sort');
echo \yii\bootstrap\Html::submitButton('添加菜单',['class'=>'btn btn-info col-lg-offset-8']);
\yii\bootstrap\ActiveForm::end();