<h3 style="margin-left: 20%;margin-bottom: 30px">添加商品分类</h3>
<?php
$form=\yii\bootstrap\ActiveForm::begin(['layout' => 'horizontal']);
echo $form->field($model,'tree');
echo $form->field($model,'lft');
echo $form->field($model,'rgt');
echo $form->field($model,'rgt');
echo $form->field($model,'depth');
echo $form->field($model,'name');
echo $form->field($model,'parent_id');
echo $form->field($model,'intro');
echo \yii\bootstrap\Html::submitButton('添加',['class'=>'btn btn-info col-lg-offset-8']);
\yii\bootstrap\ActiveForm::end();