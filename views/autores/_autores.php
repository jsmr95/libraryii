<?php

use yii\data\Pagination;

use yii\helpers\Url;
use yii\helpers\Html;

use yii\widgets\LinkPager;

?>
<style media="screen">
.right{
    float: right;
    margin-top: 7px;
}
.autor {
    padding: 23px;
}
.autor-cuerpo {
    background-color: #e8edff;
    position: relative;
    padding: 5px 10px 5px 30px;
    border-radius: 6px;
    -webkit-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    -moz-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);

}
.autor-texto {
    padding-top: 30px;
    padding-bottom: 50px;
    font-family: cursive;
}
.glyphicon-trash {
    color:red;
    font-size: 20px !important;
}
.glyphicon-trash:hover {
    color:blue;
    font-size: 18px !important;
}
.enlace {
    margin-left: 15px !important;
}

</style>

<div class="row autor">
    <div class="autor-cuerpo col-md-12">
        <div class="col-md-3">
            <!-- Imagen AQUI -->
            <center>
                <p>
                <?php
                if (empty($model->imagen)) {
                    echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg');
                } else {
                    echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen);
                }
                ?>
                </p>
            </center>
        </div>
        <div class=" col-md-7">
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
            <p class="autor-texto">
                <?= $model->descripcion  ?>
            </p>
        </div>
    </div>
</div>
