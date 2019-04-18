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
.glyphicon-trash {
    color:red;
    font-size: 20px !important;
}

img.librosAutor {
    width: 50px !important;
    height: 70px !important;
    border-radius: 3px;
    margin-top: 25%;
}

</style>
<div class="row libro">
    <div class="libro-cuerpo col-md-10">
        <div class="col-md-2">
            <!-- Imagen AQUI -->
            <center>
                <p>
                <?php
                if (empty($model->imagen)) {
                    echo Html::img(Yii::getAlias('@uploads').'/libroDefecto.png', ['class' => 'librosAutor']);
                } else {
                    echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'librosAutor']);
                }
                ?>
                </p>
            </center>
        </div>
        <div class=" col-md-8">
            <h3>
                <?= Html::a($model->titulo, ['libros/view', 'id' => $model->id]) ?>
            </h3>
            <p class="libro-texto">
                <?= $model->sinopsis ?>
            </p>
        </div>
    </div>

</div>
