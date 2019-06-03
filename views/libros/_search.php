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
            <?php echo $sort->link('titulo') ?>
            <?= $form->field($model, 'titulo')->label(false) ?>
            <?php echo $sort->link('anyo') ?>
            <?= $form->field($model, 'anyo')->label(false) ?>
            <?php echo $sort->link('genero.genero') ?>
            <?= $form->field($model, 'genero.genero')->label(false) ?>
            <?php echo $sort->link('autor.nombre') ?>
            <?= $form->field($model, 'autor.nombre')->label(false) ?>
            <!-- Buscar por autor -->

            <div class="form-group">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
