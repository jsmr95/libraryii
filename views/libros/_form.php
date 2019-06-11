<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Libros */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="libros-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'id' => 'login-form-vertical',
        'type' => ActiveForm::TYPE_VERTICAL
    ]); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anyo')->textInput() ?>

    <?= $form->field($model, 'sinopsis')->textarea(['rows' => 10]) ?>

    <?= $form->field($model, 'url_compra')->textInput(['maxlength' => true])->label('Url de Compra') ?>

    <?= $form->field($model, 'autor_id')->dropDownList($listaAutores) ?>

    <?= $form->field($model, 'genero_id')->dropDownList($listaGeneros) ?>

    <?= $form->field($model, 'imagen')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($titulo, ['class' => 'btn btn-success']) ?>
        <?= Html::a('Volver', ['libros/view', 'id' => $model->id], ['class' => 'btn btn-success btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
