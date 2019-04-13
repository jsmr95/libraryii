<?php

use app\models\Usuarios;

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
        <span>
            <h2>
                <?php
                $usua = Usuarios::findOne(['id' => $model->usuario->id]);
                //var_dump($usua); die();
                ?>
                <?= Html::a(
                    $usua->nombre,
                    ['usuarios/view',
                        'id' => $model->usuario->id
                    ]) ?>
                <small style="font-size: 12px;">
                    <?= Yii::$app->formatter
                        ->asRelativeTime($model->created_at)
                    ?>
                </small>
            </h2>
        </span>
            <p class="autor-texto">
                <?= $model->estado  ?>
            </p>
        </div>
    </div>

</div>
