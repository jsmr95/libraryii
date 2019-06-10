<?php

use yii\data\Pagination;

use yii\helpers\Url;
use yii\helpers\Html;

use yii\widgets\LinkPager;

?>
<div class="row autor">
    <!-- Fila por cada autor -->
    <div class="autor-cuerpo col-md-12 " itemscope itemtype="http://schema.org/Person">
        <!-- Caja de información-->
        <div class="col-md-3 " style="text-align: center">
            <!-- Imagen AQUI -->
            <p itemprop="image">
            <?php
            if (empty($model->imagen)) {
                echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg', ['class' => 'autoresIndex']);
            } else {
                echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'autoresIndex']);
            }
            ?>
            </p>
        </div>
        <div class=" col-md-7 " itemprop="name">
            <!-- Información del autor -->
            <h2>
                <?= Html::a($model->nombre, ['autores/view', 'id' => $model->id]) ?>
                <?php
                    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login === 'admin'){

                echo Html::a( "<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>",
                [ 'autores/delete', 'id' => $model->id ],
                [ 'data' =>
                    [
                        'method' => 'POST',
                        'confirm' => "¿Seguro que quieres eliminar a '$model->nombre'?"
                    ]
                ]);
                    }
                ?>

            </h2>
            <p class="autor-texto" itemprop="description">
                <?= $model->descripcion  ?>
            </p>
        </div>
    </div>
</div>
