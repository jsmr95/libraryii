<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>
<style media="screen">
/* .libro {
    padding: 1px;
    margin-right: 15px;
}
.libro-cuerpo {
    background-color: #e8edff;
    position: relative;
    padding: 3px 0px 3px 0px;
    border-radius: 6px;
    -webkit-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    -moz-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);

} */
/* .libro-texto {
    padding-top: 3px;
    padding-bottom: 7px;
    font-family: cursive;
} */

img.librosUsuarios {
    width: 90px !important;
    height: 120px !important;
    border-radius: 3px;
    margin-top: 20px !important;
}
</style>
<!-- Fila de cada libro -->
<div class=" col-md-2 col-xs-6 " style="text-align: center">
    <!-- Columna de 10 y separado 1 para cada libro-->
    <!-- Imagen AQUI -->
    <p>
    <?php
    if (empty($model->imagen)) {
        echo Html::img(Yii::getAlias('@uploads').'/libroDefecto.png', ['class' => 'librosUsuarios']);
    } else {
        echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'librosUsuarios']);
    }
    ?>
    </p>
    <h5>
        <?= Html::a($model->titulo, ['libros/view', 'id' => $model->id], ['class' => 'tituloLibro']) ?>
    </h5>
</div>
