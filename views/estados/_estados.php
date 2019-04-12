<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>
<style media="screen">

</style>
<div class="row ">
    <div class=" col-md-12">
        <div class=" col-md-3">
            <!-- Imagen AQUI -->
            <center>
                <p>

                </p>
            </center>
        </div>
        <div class=" col-md-7">
            <h2>
                <?= Html::a($model->usuario->nombre, ['usuarios/view', 'id' => $model->usuario->id]) ?>
            </h2>
            <p class="autor-texto">
                <?= $model->estado  ?>
            </p>
        </div>
    </div>

</div>
