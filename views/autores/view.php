<?php

use app\models\Libros;
use app\models\AutoresFavs;

use yii\data\ActiveDataProvider;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Autores */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Autores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>

img.autores {
    width: 190px !important;
    height: 225px !important;
    border-radius: 20px;
}
span.glyphicon {
    color:red;
}

</style>
<div class="container">
    <!--Contenedor para el libro -->
    <?php
    //Variables que voy a usar
    $id = $model->id;
    $fila = AutoresFavs::find()->where(['usuario_id' => $id])->one();
    $corazon = $model->consultaAutorSeguido(Yii::$app->user->id, $id);
    $url = Url::to(['autores-favs/create']);
    $url1 = Url::to(['autores/consultaseguidores']);
    $followJs = <<<EOT

    function seguir(event){
        $.ajax({
            url: '$url',
            data: { autor_id: '$id'},
            success: function(data){
                if (data == '') {
                    $('#corazon').removeClass('glyphicon-heart-empty');
                    $('#corazon').addClass('glyphicon-heart');
                    $.ajax({
                        url: '$url1',
                        data: { autor_id: '$id'},
                        success: function(data){
                            console.log(data);
                            $('#seguidores')[0].firstChild.nodeValue = data;
                        }
                    });
                } else {
                    $('#corazon').removeClass('glyphicon-heart');
                    $('#corazon').addClass('glyphicon-heart-empty');
                    $.ajax({
                        url: '$url1',
                        data: { autor_id: '$id'},
                        success: function(data){
                            console.log(data);
                            $('#seguidores')[0].firstChild.nodeValue = data;
                        }
                    });
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
    <!-- Nombre y corazón para saber si lo sigo-->
    <?php if (!Yii::$app->user->isGuest) { ?>
    <center>
        <h1>
            <?= Html::encode($this->title)?>
            <button class="follow">
                <span id="corazon" class='glyphicon glyphicon-heart<?=$corazon?>' aria-hidden='true'></span>
            </button>
        </h1>
    </center>
    <?php } ?>
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
                'confirm' => 'Estas seguro de borrar este autor?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    </center>
    <?php } } ?>

    <div class="container">
        <!-- Contenedor de cada autor -->
        <div class="row">
            <div class="col-md-offset-5 col-md-2">
                <!-- Fila donde colocamos la imagen-->
                <br>
                <?php
                if (empty($model->imagen)) {
                    echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg', ['class' => 'autores']);
                } else {
                    echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'autores']);
                }
                ?>
                <center>
                    <p style="margin-top: 15px">Seguidores:
                        <span id="seguidores">
                        <?= Yii::$app->runAction('autores/consultaseguidores', ['autor_id' => $model->id]) ?>
                        </span>
                    </p>
                </center>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <!-- Fila donde ponemos la información principal-->
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <center>
                      Información Principal
                    </center>
                  </div>
                  <div class="panel-body">
                      <p>Nombre: <?= $model->nombre ?></p>
                      <p>Descripción: <?= $model->descripcion ?></p>
                  </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Fila donde colocamos los libros escritos por el autor-->
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <center>
                      Libros de <?= $model->nombre ?>
                    </center>
                  </div>
                  <div class="panel-body">
                        <?php
                        $dataProvider = new ActiveDataProvider([
                            'query' => Libros::find()->where(['autor_id' => $model->id]),
                        ]);
                        echo ListView::widget([
                          'dataProvider' => $dataProvider,
                          'summary' => '',
                          'itemView' => '_librosAutor',
                      ]); ?>
                  </div>
                </div>
            </div>
        </div>
    </div>

</div>
