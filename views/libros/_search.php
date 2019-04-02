<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LibrosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="libros-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'isbn') ?>

    <?= $form->field($model, 'anyo') ?>

    <?= $form->field($model, 'sinopsis') ?>

    <?php // echo $form->field($model, 'url_compra') ?>

    <?php // echo $form->field($model, 'autor_id') ?>

    <?php // echo $form->field($model, 'genero_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
