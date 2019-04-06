<?php
use app\models\Libros;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<style media="screen">
.right{
    float: right;
    margin-top: 7px;
}
.libro {
    padding: 17px;
}
.libro-cuerpo {
    background-color: #e8edff;
    position: relative;
    padding: 5px 10px 5px 30px;
    border-radius: 6px;
    -webkit-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    -moz-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
}
.libro-texto {
    padding-top: 55px;
    font-family: cursive;
}
</style>
<div class="row libro">
    <div class="libro-cuerpo col-md-12">
        <div class="libro-cuerpo col-md-3">
            <!-- Imagen AQUI -->
            <center>
                <p>
                    Aqui va la imagen!
                </p>
            </center>
        </div>
        <div class="libro-cabecera col-md-4">
            <p>
                <h2>
                    <?= Html::a($model->titulo, [
                    'libros/view',
                    'id' => $model->id
                    ]) ?>
                </h2>
                <ul>
                    <li>Autor: <?= $model->autor->nombre ?></li>
                    <li>Año: <?= $model->anyo ?></li>
                    <li>Género: <?= $model->genero->genero ?></li>
                    <li>ISBN: <?= $model->isbn ?></li>
                    <li> <?= Html::a('Compra', $model->url_compra) ?>
                    </li>
                </ul>
            </p>
        </div>
        <div class="libro-texto col-md-5">
            <?= $model->sinopsis  ?>
        </div>
    </div>

</div>
