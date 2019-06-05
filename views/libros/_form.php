<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Libros */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="libros-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anyo')->textInput() ?>

    <?= $form->field($model, 'sinopsis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url_compra')->textInput(['maxlength' => true])->label('Url de Compra') ?>

    <?= $form->field($model, 'autor_id')->dropDownList($listaAutores) ?>

    <?= $form->field($model, 'genero_id')->dropDownList($listaGeneros) ?>

    <?= $form->field($model, 'imagen')->input('file') ?>

    <div class="form-group">
        <?= Html::submitButton($titulo, ['class' => 'btn btn-success']) ?>
        <?= Html::a('Volver', ['libros/view', 'id' => $model->id], ['class' => 'btn btn-success btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
