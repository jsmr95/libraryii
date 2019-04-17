<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->nombre . ' ' . $model->apellido;
$this->params['breadcrumbs'][] = ['label' => 'Social', 'url' => ['estados/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>

img[src^="https://s3.eu-west-2.amazonaws.com/imagesjsmr95"] {
    width: 190px !important;
    height: 225px !important;
    border-radius: 110px;
}

</style>
<div class="container">
    <?php
    $corazon = '-empty';
    ?>
    <center>
        <h1>
            <?= Html::encode($this->title)?>
            <?= Html::a("<span class='glyphicon glyphicon-heart$corazon' aria-hidden='true'></span>", '#') ?>
        </h1>
    </center>

    <?php
    if (!Yii::$app->user->isGuest){
        if (Yii::$app->user->identity->login === $model->login){
            ?>
<div class="row">
    <div class="col-md-offset-5 col-md-2">
    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar cuenta', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estás seguro que desea eliminar su cuenta? Se eliminará TODO su contenido registrado!',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
</div>
<?php } }  ?>

    <div class="row">
        <div class="col-md-offset-5 col-md-2">
            <br>
            <?php
            if (empty($model->url_avatar)) {
                echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg');
            } else {
                echo Html::img(Yii::getAlias('@uploads').'/'.$model->url_avatar);
            }
            ?>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
              <div class="panel-heading">Información Cuenta</div>
              <div class="panel-body">
                  <p>Login: <?= $model->login ?></p>
                  <p>Email: <?= $model->email ?></p>
              </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
              <div class="panel-heading">Información Personal</div>
              <div class="panel-body">
                  <p>Nombre: <?= $model->nombre ?></p>
                  <p>Apellido: <?= $model->apellido ?></p>
                  <p>Biografía: <?= $model->biografia ?></p>
                  <p>Autenticado: <?php
                   if (empty($model->auth_key)) {?>
                       Verificado!
                   <?php } else {?>
                   NO verificado!
                   <?php } ?>
                   </p>
                  <p>Creado: <?= $model->created_at ?></p>
                  <p>Última modificación: <?= $model->updated_at ?></p>
              </div>
            </div>
        </div>
    </div>

</div>
