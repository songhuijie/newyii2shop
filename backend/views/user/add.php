<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = '添加新用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = \yii\bootstrap\ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('用户名') ?>

            <?= $form->field($model, 'email')->label('邮箱') ?>

            <?= $form->field($model, 'password')->passwordInput()->label('密码') ?>
            <?= $form->field($model, 'roleoptions',['inline'=>true])->checkboxList(\backend\models\UserBackend::getroles()) ?>

            <div class="form-group">
                <?= \yii\bootstrap\Html::submitButton('添加', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php \yii\bootstrap\ActiveForm::end(); ?>
        </div>
    </div>
</div>