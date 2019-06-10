<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<!-- Fila de cada libro -->
<div class=" col-md-2 col-lg-2 col-xs-2 " style="text-align: center">
    <!-- Columna de 10 y separado 1 para cada libro-->
    <!-- Imagen AQUI -->
    <p>
    <?php
    if (empty($model->imagen)) {
        echo Html::img(Yii::getAlias('@uploads').'/libroDefecto.png', ['class' => 'librosUsuariosAutores']);
    } else {
        echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'librosUsuariosAutores']);
    }
    ?>
    </p>
    <h5>
        <?= Html::a($model->titulo, ['libros/view', 'id' => $model->id], ['class' => 'tituloLibro']) ?>
    </h5>
</div>
