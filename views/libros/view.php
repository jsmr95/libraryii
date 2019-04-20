<?php

use app\models\Usuarios;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

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

</style>
<?php
$url = Url::to(['libros-favs/create']);
$id = $model->id;
$followJs = <<<EOT

function seguir(event){
    $.ajax({
        url: '$url',
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

$(document).ready(function(){
    $('.follow').click(seguir);
});
EOT;
$this->registerJs($followJs);
?>
<div class="libros-view">

    <center>
        <h1><?= Html::encode($this->title) ?>
        <?php
        if (!Yii::$app->user->isGuest) {
            $usuario = Usuarios::find(Yii::$app->user->id)->one();
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
        <div class="row">
            <div class="col-md-offset-5 col-md-2">
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
        <br>
        <br>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
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
