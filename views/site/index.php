<?php

/* @var $this yii\web\View */
use app\models\Libros;

use yii\data\ActiveDataProvider;

use yii\helpers\Html;

use yii\widgets\ListView;

$this->title = 'Libraryii';
 ?>
 <style>
 body {
    background-image: url(<?= Yii::getAlias('@uploads').'/libreria.jpg' ?>);
    height: auto !important;
}
</style>
<br><br><br>
    <p style="text-align: center;font-size: 30pt">¡Bienvenidos a Libraryii!</p>
<br><br><br>
<div class="row">
    <div class="col-md-8" style="font-size:28px">
        <p>Libraryii es una red social orientada a todos los amantes de los
            libros. Si te consideras uno de ellos y ademas te gusta sumergirte en un sin
            fin de historias, estas en el lugar idóneo.</p><br>
        <p>Aquí podrás organizar el seguimiento de tus libros, marcandolos en favoritos,
        leidos, por leer o leyendo, además de poder interactuar con los demás usuarios,
    viendo las interacciones que realiza.</p>
    </div>
    <div class="col-md-3 col-md-offset-1 libros" style="text-align: center; margin-top: -30px">
        <p style="text-decoration: underline;font-size: 24pt; ">Más valorado</p><br>
        <?php
        $dataProvider = new ActiveDataProvider([
            'query' => Libros::find()->where(['id' =>$libroMasVotado->id])
        ]);
        echo ListView::widget([
          'dataProvider' => $dataProvider,
          'summary' => '',
          'itemView' => '_ultimoLanzamientoMedia',
      ]); ?>
    <br>
        <p style="text-decoration: underline;font-size: 24pt; ">Último lanzamiento</p><br>
        <?php
        $dataProvider = new ActiveDataProvider([
            'query' => Libros::find()->where(['id' =>$ultimoLanzamiento->id])
        ]);
        echo ListView::widget([
          'dataProvider' => $dataProvider,
          'summary' => '',
          'itemView' => '_ultimoLanzamientoMedia',
        ]); ?>
    </div>
</div>
