<style media="screen">

    .field-loginform-username, .field-loginform-password, .field-loginform-rememberme{
        margin-left: 36% !important;
    }
    #loginform-username:focus, #loginform-password:focus{
        transition: 0.3s;
        width: 230px;
        border-radius: 20px;
    }
</style>
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Logueo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login" style="text-align: center">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Use su usuario o email y contraseña para loguearse:</p>
    <br>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
        'options' => [
            'class' => 'box',
        ]
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Usuario/Email'])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Contraseña'])->label(false) ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ])->label('Recuerdame') ?>

    <div class="form-group">
        <div class="col-md-offset-1 col-md-11">
            <!-- Botón Login -->
            <?= Html::submitButton('Logueo', ['submit class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
        <div class="col-md-offset-1 col-md-11">
            <br>
            <?= Html::a('Olvidé mi contraseña', ['usuarios/recuperarcontra']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
