<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Autores */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Autores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>

img[src^="https://s3.eu-west-2.amazonaws.com/imagesjsmr95"] {
    width: 190px !important;
    height: 225px !important;
    border-radius: 20px;
}

</style>
<div class="libros-view">

    <center>
        <h1><?= Html::encode($this->title) ?></h1>
    </center>
    <!-- Muestro estas opciones solo para el admin -->
    <?php
        if (!Yii::$app->user->isGuest){
        if (Yii::$app->user->identity->login === 'admin'){
    ?>
    <center>    
    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de borrar este autor?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    </center>
    <?php } } ?>

    <div class="container">
        <div class="row">
            <div class="col-md-offset-5 col-md-2">
                <br>
                <?php
                if (empty($model->imagen)) {
                    echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg');
                } else {
                    echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen);
                }
                ?>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <center>
                      Información Principal
                    </center>
                  </div>
                  <div class="panel-body">
                      <p>Nombre: <?= $model->nombre ?></p>
                      <p>Descripción: <?= $model->descripcion ?></p>
                  </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <center>
                      Libros de <?= $model->nombre ?>
                    </center>
                  </div>
                  <div class="panel-body">
                      <p>Aqui van todos sus libros</p>
                  </div>
                </div>
            </div>
        </div>
    </div>

</div>
