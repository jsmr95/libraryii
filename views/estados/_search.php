<style media="screen">
    #estadossearch-estado {
        width: 300px;
    }
</style>
<?php

// use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EstadosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estados-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <!-- Solo buscamos por palabras en el estado -->
    <?= $form->field($model, 'estado')->input('text', ['placeholder' => 'Buscar']) ?>


    <!-- <div class="form-group">
        <?php //echo Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div> -->

    <?php ActiveForm::end(); ?>

</div>
