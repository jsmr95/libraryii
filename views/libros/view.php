<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Libros */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
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
    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php } } ?>

    <div class="container">
        <div class="row">
            <div class="col-md-offset-5 col-md-2">
                <br>
                <?php
                if (empty($model->imagen)) {
                    echo Html::img(Yii::getAlias('@uploads').'/libroDefecto.png');
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
                      <p>Titulo: <?= $model->titulo ?></p>
                      <p>ISBN: <?= $model->isbn ?></p>
                      <p>Año: <?= $model->anyo ?></p>
                      <p>Sinopsis: <?= $model->sinopsis ?></p>
                      <p>Compra: <?= Html::a('Compra', $model->url_compra) ?></p>
                      <p>
                          Autor: <?= Html::a($model->autor->nombre, ['autores/view', 'id' => $model->autor->id])?>
                      </p>
                      <p>Género: <?= $model->genero->genero ?></p>
                  </div>
                </div>
            </div>
        </div>
    </div>

</div>
