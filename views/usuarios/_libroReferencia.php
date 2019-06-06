<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="row">
    <!-- Fila de cada libro -->
    <!-- Imagen AQUI -->
    <center>
        <p style="margin-top: -15px">
        <?php
        if (empty($model->imagen)) {
            echo Html::img(Yii::getAlias('@uploads').'/libroDefecto.png', ['class' => 'librosUsuariosPerfil']);
        } else {
            echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'librosUsuariosPerfil']);
        }
        ?>
        </p>
    </center>
</div>
<div class="row" style="margin-top: -10px">
    <!-- Fila para cada titulo del libro-->
    <center>
        <h5>
            <?= Html::a($model->titulo, ['libros/view', 'id' => $model->id], ['class' => 'tituloLibro']) ?>
        </h5>
    </center>
</div>
