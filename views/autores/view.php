<?php

use app\models\Libros;

use yii\data\ActiveDataProvider;

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Autores */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Autores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>

img.autores {
    width: 190px !important;
    height: 225px !important;
    border-radius: 20px;
}

</style>
<div class="libros-view">
    <!-- Titulo del autor y las opciones para modificarlo-->
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
        <!-- Contenedor de cada autor -->
        <div class="row">
            <div class="col-md-offset-5 col-md-2">
                <!-- Fila donde colocamos la imagen-->
                <br>
                <?php
                if (empty($model->imagen)) {
                    echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg', ['class' => 'autores']);
                } else {
                    echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'autores']);
                }
                ?>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <!-- Fila donde ponemos la información principal-->
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
            <!-- Fila donde colocamos los libros escritos por el autor-->
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <center>
                      Libros de <?= $model->nombre ?>
                    </center>
                  </div>
                  <div class="panel-body">
                        <?php
                        $dataProvider = new ActiveDataProvider([
                            'query' => Libros::find()->where(['autor_id' => $model->id]),
                        ]);
                        echo ListView::widget([
                          'dataProvider' => $dataProvider,
                          'summary' => '',
                          'itemView' => '_librosAutor',
                      ]); ?>
                  </div>
                </div>
            </div>
        </div>
    </div>

</div>
