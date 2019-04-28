<?php

use app\models\Votos;
use app\models\Usuarios;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model app\models\Libros */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>

img.libros {
    width: 190px !important;
    height: 225px !important;
    border-radius: 20px;
}

span#estrella{
    color: rgb(255, 233, 0);
}

.caption {
    display: none !important;
}

</style>
<?php
$url1 = Url::to(['libros-favs/create']);
$url2 = Url::to(['votos/create']);
$id = $model->id;
$usuarioId = Yii::$app->user->id;
$followJs = <<<EOT

function seguir(event){
    $.ajax({
        url: '$url1',
        data: { libro_id: '$id'},
        success: function(data){
            if (data == '') {
                $('#estrella').removeClass('glyphicon-star-empty');
                $('#estrella').addClass('glyphicon-star');
            } else {
                $('#estrella').removeClass('glyphicon-star');
                $('#estrella').addClass('glyphicon-star-empty');
            }
        }
    });
}


function votar(event){
    var valorVoto;
    var relleno = $('.rating-stars').attr('title');
    switch (relleno) {
        case 'Una Estrella':
            valorVoto = 1;
            break;
        case 'Dos Estrellas':
            valorVoto = 2;
            break;
        case 'Tres Estrellas':
            valorVoto = 3;
            break;
        case 'Cuatro Estrellas':
            valorVoto = 4;
            break;
        case 'Cinco Estrellas':
            valorVoto = 5;
            break;
        default:
            valorVoto = 0;
    }
    console.log(relleno);
    $.ajax({
        url: '$url2',
        data: { libro_id: '$id',
                usuario_id: '$usuarioId',
                voto: valorVoto},
        success: function(data){
            console.log(data);
        }
    });
}

$(document).ready(function(){
    $('.follow').click(seguir);
    $('.rating-stars').change(votar);
});
EOT;
$this->registerJs($followJs);
?>
<div class="libros-view">
    <!-- Titulo del libro y botón para seguirlo-->
    <center>
        <h1><?= Html::encode($this->title) ?>
        <?php
        $corazon = '';
        if (!Yii::$app->user->isGuest) {
            $usuario = Usuarios::findOne(Yii::$app->user->id);
            $corazon = $usuario->consultaLibroSeguido($usuario->id, $model->id);
            ?>
            <button class="follow">
                <span id="estrella" class='glyphicon glyphicon-star<?=$corazon?>' aria-hidden='true'></span>
            </button>
        <?php } ?>
        </h1>
    </center>
    <!-- Muestro estas opciones solo para el admin -->
    <?php
        if (!Yii::$app->user->isGuest){
        if (Yii::$app->user->identity->login === 'admin'){
    ?>
    <center>
    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de borrar este libro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    </center>
    <?php } } ?>

    <div class="container">
        <!-- Contenedor de cada libro -->
        <div class="row">
            <!-- Fila del libro donde incluye la imagen-->
            <div class="col-md-offset-5 col-md-2">
                <!-- Columna de 2 y separada 5 que incluye la imagen del libro -->
                <br>
                <?php
                if (empty($model->imagen)) {
                    echo Html::img(Yii::getAlias('@uploads').'/libroDefecto.png', ['class' => 'libros']);
                } else {
                    echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'libros']);
                }
                ?>
            </div>
        </div>
        <br><br>
        <?php if (!Yii::$app->user->isGuest) {
            $votante = Votos::find()->where(['usuario_id' => $usuarioId,
                                             'libro_id' => $id])->one();
            if ($votante) {
                $voto = $votante->voto;
            }else {
                $voto = 0;
            }
            ?>
        <div class="row">
            <center>
                <label class="control-label">Valora el libro:</label>
                <?= StarRating::widget(['name' => 'rating',
                                        'value' => $voto,
                                        'pluginOptions' => [
                                            'step' => 1 ]
                                        ]);
                ?>
                <!-- <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="1"> -->
            </center>
        </div>
        <br>
        <br>
    <?php } ?>
        <div class="row">
            <!-- Fila del libro donde está la información -->
            <div class="col-md-8 col-md-offset-2">
                <!-- Columna de 8 y separada 2 para la información principal-->
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <center>
                      Información Principal
                    </center>
                  </div>
                  <div class="panel-body">
                      <p>Titulo: <?= $model->titulo ?></p>
                      <p>ISBN: <?= $model->isbn ?></p>
                      <p>Año: <?= $model->anyo ?></p>
                      <p>Sinopsis: <?= $model->sinopsis ?></p>
                      <p>Compra: <?= Html::a('Compra', $model->url_compra) ?></p>
                      <p>
                          Autor: <?= Html::a($model->autor->nombre, ['autores/view', 'id' => $model->autor->id])?>
                      </p>
                      <p>Género: <?= $model->genero->genero ?></p>
                  </div>
                </div>
            </div>
        </div>
    </div>

</div>
