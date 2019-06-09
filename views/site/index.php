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
footer{
    display: none;
}
.libros {
    margin-top: -30px;
}
</style>

<br><br><br>
<center>
    <h1>¡Bienvenidos a Libraryii!</h1>
</center>
<br><br><br>
<div class="row">
    <div class="col-md-8" style="font-size:28px">
        <p>Libraryii es una red social orientada a todos los amantes de los
            libros. En esta web podrás tener organizado el seguimiento de tus
            libros. Clasificarlos en 'leidos', 'leyendo', 'por leer', marcar libros
            como favoritos.</p><br>
        <p>Si eres un amante de los libros y te gusta sumergite en un sin fin de
    historias, estás en el lugar idóneo. Aquí podrás interactuar con otros usuarios,
    comentar que te ha parecido un libro, hacer lybs, marcar como me favorito
    libro e inclusive seguir a otros usuarios para ver sus interacciones.</p>
    </div>
    <div class="col-md-3 col-md-offset-1 libros">
        <center>
            <h2 style="text-decoration: underline; ">Más valorado</h2><br>
            <?php
            $dataProvider = new ActiveDataProvider([
                'query' => Libros::find()->where(['id' =>$libroMasVotado->id])
            ]);
            echo ListView::widget([
              'dataProvider' => $dataProvider,
              'summary' => '',
              'itemView' => '_ultimoLanzamientoMedia',
          ]); ?>
        </center>
        <br>
        <center>
            <h2 style="text-decoration: underline; ">Último lanzamiento</h2><br>
            <?php
            $dataProvider = new ActiveDataProvider([
                'query' => Libros::find()->where(['id' =>$ultimoLanzamiento->id])
            ]);
            echo ListView::widget([
              'dataProvider' => $dataProvider,
              'summary' => '',
              'itemView' => '_ultimoLanzamientoMedia',
            ]); ?>
        </center>
    </div>
</div>
