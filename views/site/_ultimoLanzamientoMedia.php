<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

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
