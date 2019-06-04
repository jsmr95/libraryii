<style media="screen">
    #usuariossearch-login {
        width: 300px;
    }
</style>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosFavsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //echo $form->field($model, 'id') ?>

    <?= $form->field($model, 'login')->label('Usuarios') ?>

    <?php //echo $form->field($model, 'email') ?>

    <?php //echo $form->field($model, 'nombre') ?>

    <?php //echo $form->field($model, 'apellido') ?>

    <?php // echo $form->field($model, 'biografia') ?>

    <?php // echo $form->field($model, 'url_avatar') ?>

    <?php // echo $form->field($model, 'pass') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
