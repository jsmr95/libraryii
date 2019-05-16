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
    width: 50px !important;
    height: 70px !important;
    border-radius: 3px;
    margin-top: 20px !important;
}
</style>
<div class="row libro">
    <!-- Fila de cada libro -->
    <div class="libro-cuerpo col-md-10 col-md-offset-1">
        <!-- Columna de 10 y separado 1 para cada libro-->
        <div class="col-md-2">
            <!-- Imagen AQUI -->
            <center>
                <p>
                <?php
                if (empty($model->imagen)) {
                    echo Html::img(Yii::getAlias('@uploads').'/libroDefecto.png', ['class' => 'librosUsuarios']);
                } else {
                    echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'librosUsuarios']);
                }
                ?>
                </p>
            </center>
        </div>
    <div class="row">
        <!-- Fila para cada titulo del libro-->
        <div class=" col-md-8 col-md-offset-1">
            <!-- Columna de 8 y separada 1 para el titulo-->
            <center>
                <h5>
                    <?= Html::a($model->titulo, ['libros/view', 'id' => $model->id], ['class' => 'tituloLibro']) ?>
                </h5>
            </center>
        </div>
    </div>
    </div>

</div>
