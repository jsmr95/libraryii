<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LibrosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="libros-search">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form-inline',
        'type' => ActiveForm::TYPE_INLINE,
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row" >
        <div class="col-md-12 col-xs-12" style="padding:20px; border-radius:9px;">
            <?php echo $sort->link('titulo') ?>
            <?= $form->field($model, 'titulo')->label(false) ?>
            <?php echo $sort->link('anyo') ?>
            <?= $form->field($model, 'anyo')->label(false) ?>
            <?php echo $sort->link('genero.genero', ['label' => 'Género']) ?>
            <?= $form->field($model, 'genero.genero')->label(false) ?>
            <?php echo $sort->link('autor.nombre', ['label' => 'Autor']) ?>
            <?= $form->field($model, 'autor.nombre')->label(false) ?>
            <!-- Buscar por autor -->

            <div class="form-group">
                <?php echo Html::submitButton('Buscar', ['class' => 'btn btn-primary', 'style' => 'margin-top: 15px']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
