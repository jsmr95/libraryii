<?php
/* @var $this \yii\web\View view component instance */
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $message \yii\mail\BaseMessage instance of newly created mail message */
?>
<h2>Puedes reestablecer su contraseña desde el enlace de abajo.</h2>
<?php $form = ActiveForm::begin([
    'action' => Url::to(['usuarios/modificarcontra'], true),
]);?>

<?= $form->field($model, 'id')->hiddenInput()->label(false)  ?>

<button type="submit" name="button">Restablecer contraseña </button>
<?php ActiveForm::end() ?>
