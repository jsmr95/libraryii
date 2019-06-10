<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'id' => 'login-form-vertical',
        'type' => ActiveForm::TYPE_VERTICAL
    ]); ?>

    <div class="col-md-8">
        <!-- Personales -->
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <!-- Datos cuenta -->

        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'biografia')->textarea(['rows' => 10]) ?>

        <?= $form->field($model, 'url_avatar')->fileInput() ?>

        <?= $form->field($model, 'auth_key')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>

        <div class="form-group" style="text-align: center">
            <?= Html::submitButton($titulo, ['class' => 'btn btn-success']) ?>
            <?= Html::a('Volver', ['usuarios/view', 'id' => $model->id], ['class' => 'btn btn-success btn-danger']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
