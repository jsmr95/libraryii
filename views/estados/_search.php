<style media="screen">
    #estadossearch-estado, #estadossearch-libro-titulo {
        width: 300px;
    }
</style>
<?php

// use yii\helpers\Html;
use yii\helpers\Html;

use kartik\form\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\EstadosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estados-search">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form-inline',
        'type' => ActiveForm::TYPE_INLINE,
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="form-group">
    <!-- Solo buscamos por palabras en el estado -->
    <?php //echo $form->field($model, 'estado')->input('text', ['placeholder' => 'Buscar contenido...'])->label(false) ?>
    <?= $form->field($model, 'estado')->input('text', ['placeholder' => 'Buscar contenido...'])->label(false) ?>
    <?= $form->field($model, 'libro.titulo')->input('text', ['placeholder' => 'Buscar libro...', 'style' => 'margin-left: 15px'])->label(false) ?>

    </div>
    <br>
    <br>
    <?php echo Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>
