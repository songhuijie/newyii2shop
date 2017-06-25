<?php

$form=\yii\bootstrap\ActiveForm::begin(['layout' => 'horizontal']);
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'article_category_id')->dropDownList(\yii\helpers\ArrayHelper::map($acttocate,'id','name'));
echo $form->field($model,'sort');
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Acticle::$statusoptions);
//echo $form->field($actdetail,'content')->textarea();
//echo \kucha\ueditor\UEditor::widget(['name' => 'content']);
echo $form->field($actdetail,'content')->widget('kucha\ueditor\UEditor',[]);
echo \yii\bootstrap\Html::button('添加',['id'=>'submit-btn']);
\yii\bootstrap\ActiveForm::end();
