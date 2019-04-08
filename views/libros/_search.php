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

    <div class="row" >
        <div class="col-md-3" style="border:1px solid; padding:20px; border-radius:9px">

            <?= $form->field($model, 'titulo') ?>
            <?= $form->field($model, 'anyo') ?>
            <?= $form->field($model, 'genero_id') ?>

            <div class="form-group">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
