<?php

use app\models\Libros;
use app\models\AutoresFavs;

use yii\data\ActiveDataProvider;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Autores */
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
.follow{
    padding: 0;
    border: none;
    background: none;
}
</style>

<!--Contenedor para el libro -->
<?php
$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Autores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

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
            } else {
                $('#corazon').removeClass('glyphicon-heart');
                $('#corazon').addClass('glyphicon-heart-empty');
            }
            $.ajax({
                url: '$url1',
                data: { autor_id: '$id'},
                success: function(data){
                    console.log(data);
                    $('#seguidores')[0].firstChild.nodeValue = data;
                }
            });
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
<div class="col-md-3" style="text-align: center">
    <h1>
        <?= Html::encode($this->title)?>
        <?php if (!Yii::$app->user->isGuest) { ?>
            <button class="follow" title="Marcar como favorito, esto asignará todos sus libros como favoritos">
                <span id="corazon" class='glyphicon glyphicon-heart<?=$corazon?>' aria-hidden='true'></span>
            </button>
        <?php } ?>
    </h1>
    <!-- Muestro estas opciones solo para el admin -->
    <?php
        if (!Yii::$app->user->isGuest){
        if (Yii::$app->user->identity->login === 'admin'){
    ?>
    <p style="text-align: center">
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro de borrar este autor?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php } } ?>
    <!-- colocamos la imagen-->
    <br>
    <div style="text-align: center">
        <?php
        if (empty($model->imagen)) {
            echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg', ['class' => 'autores']);
        } else {
            echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'autores']);
        }
        ?>
        <br>
        <div class="row">
            <br>
            <p style="margin-top: 15px; font-size:12px; padding:10px" class="label label-primary">Seguidores:
                <span id="seguidores">
                <?= Yii::$app->runAction('autores/consultaseguidores', ['autor_id' => $model->id]) ?>
                </span>
            </p>
        </div>
    </div>
    <br>
    <br>
</div>
<div class="col-md-9 ">
    <div class="row">
        <!-- Fila donde ponemos la información principal-->
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
              <div class="panel-heading" style="text-align: center">
                  Información Principal
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
              <div class="panel-heading" style="text-align: center">
                  Libros de <?= $model->nombre ?>
              </div>
              <div class="panel-body">
                    <?php
                    $dataProvider = new ActiveDataProvider([
                        'query' => Libros::find()->where(['autor_id' => $model->id]),
                    ]);
                    $dataProvider->setSort([
                        'defaultOrder' => ['created_at' => SORT_DESC],
                    ]);
                    $dataProvider->pagination = ['pageSize' => 5];

                    Pjax::begin();
                    echo ListView::widget([
                      'dataProvider' => $dataProvider,
                      'summary' => '',
                      'itemView' => '_librosAutor',
                  ]);
                  Pjax::end();
                  ?>
              </div>
            </div>
        </div>
    </div>
</div>
