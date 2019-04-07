<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
    ]);

    ?>
    <?= $form->field($model, 'id')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

    <!-- Personales -->
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'biografia')->textarea(['rows' => 10])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'url_avatar')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'auth_key')->hiddenInput()->label(false)->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'created_at')->hiddenInput()->label(false)->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'updated_at')->hiddenInput()->label(false)->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Modificar contraseña', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
