<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AutoresSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="autores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row" >
        <div class="col-md-3" style=" padding:20px;">

            <?php echo $sort->link('nombre'); ?>
            <?= $form->field($model, 'nombre')->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
