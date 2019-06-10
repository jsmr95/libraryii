<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>
<style media="screen">
.libro {
    padding: 13px;
}
.libro-cuerpo {
    background-color: #e8edff;
    position: relative;
    padding: 3px 5px 3px 15px;
    border-radius: 6px;
    -webkit-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    -moz-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);

}
.libro-texto {
    padding-top: 3px;
    padding-bottom: 7px;
    font-family: cursive;
}

img.librosUsuarios {
    width: 150px !important;
    height: 200px !important;
    border-radius: 3px;
    margin-top: 20px !important;
}
</style>
<div class="row libro" style="text-align: center">
    <!-- Fila de cada libro -->
    <!-- Imagen AQUI -->
    <p style="margin-top: -35px">
    <?php
    if (empty($model->imagen)) {
        echo Html::img(Yii::getAlias('@uploads').'/libroDefecto.png', ['class' => 'librosUsuarios']);
    } else {
        echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'librosUsuarios']);
    }
    ?>
    </p>
</div>
<div class="row" style="margin-top: -30px; text-align: center">
    <!-- Fila para cada titulo del libro-->
    <h5>
        <?= Html::a($model->titulo, ['libros/view', 'id' => $model->id], ['class' => 'tituloLibro']) ?>
    </h5>
</div>
