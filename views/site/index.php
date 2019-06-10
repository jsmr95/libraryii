<?php

/* @var $this yii\web\View */
use app\models\Libros;

use yii\data\ActiveDataProvider;

use yii\helpers\Html;

use yii\widgets\ListView;


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
<?php
$this->title = 'Libraryii';
 ?>
<br><br><br>
    <h1 style="text-align: center">¡Bienvenidos a Libraryii!</h1>
<br><br><br>
<div class="row">
    <div class="col-md-8" style="font-size:28px">
        <p>Libraryii es una red social orientada a todos los amantes de los
            libros. En esta web podrás tener organizado el seguimiento de tus
            libros, clasificarlos en 'leidos', 'leyendo', 'por leer', marcar libros
            como favoritos.</p><br>
        <p>Si eres un amante de los libros y te gusta sumergirte en un sin fin de
    historias, estás en el lugar idóneo. Aquí podrás interactuar con otros usuarios,
    comentar que te ha parecido un libro, hacer lybs, marcar como favorito
    libro e inclusive seguir a otros usuarios para ver sus interacciones.</p>
    </div>
    <div class="col-md-3 col-md-offset-1 libros" style="text-align: center">
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
    <br>
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
    </div>
</div>
