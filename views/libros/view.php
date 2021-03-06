<?php

use app\models\Votos;
use app\models\Libros;
use app\models\Usuarios;
use app\models\Comentarios;
use app\models\Seguimientos;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model app\models\Libros */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


$url1 = Url::to(['libros-favs/create']);
$url2 = Url::to(['votos/create']);
$url3 = Url::to(['libros/calculamediavotos']);
$url4 = Url::to(['libros/consultaseguidores']);
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
            $.ajax({
                url: '$url4',
                data: { libro_id: '$id'},
                success: function(data){
                    console.log(data);
                    $('#seguidores')[0].firstChild.nodeValue = data;
                }
            });
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

    $.ajax({
        url: '$url2',
        data: { libro_id: '$id',
                usuario_id: '$usuarioId',
                voto: valorVoto
            },
            success: function() {
                $.ajax({
                    url: '$url3',
                    data: { libro_id: '$id',
                    },
                    success: function(data){
                        $('#media').html(data);
                    }
                });
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
<div class="row">
<div class="libros-view col-md-3">
    <!-- Titulo del libro y botón para seguirlo-->
    <div class="row">
        <div class="col-md-12 " style="text-align: center">
            <h1><?= Html::encode($this->title) ?>
            <?php
            $corazon = '';
            if (!Yii::$app->user->isGuest) {
                $usuario = Usuarios::findOne(Yii::$app->user->id);
                $corazon = $usuario->consultaLibroSeguido($usuario->id, $model->id);
                $disabled = false;
                if ($corazon == 'autor') {
                    $corazon = '';
                    $disabled = true;
                }
                ?>
                <button class="follow"
                <?php if($disabled){ echo "disabled title='No puedes desmarcarlo, te gusta el autor'";}
                else {
                    echo "title='Marcar como favorito'";
                }  ?>>
                    <span id="estrella" class='glyphicon glyphicon-star<?=$corazon?>' aria-hidden='true'></span>
                </button>
            <?php } ?>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 " style="text-align: center" >
            <!-- Muestro estas opciones solo para el admin -->
            <?php
                if (!Yii::$app->user->isGuest){
                if (Yii::$app->user->identity->login === 'admin'){
            ?>
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
            <?php } } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9" style="text-align: center">
            <!-- Fila del libro donde incluye la imagen-->
            <br>
            <?php
            if (empty($model->imagen)) {
                echo Html::img(Yii::getAlias('@uploads').'/libroDefecto.png', ['class' => 'libros']);
            } else {
                echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'libros']);
            }
            ?>
        </div>
        <div class="col-md-3 " style="margin-top: 40px">
            <?php
                $numLeido = Seguimientos::find()->where(['libro_id'=>$id,'estado_id'=>1])->count();
                $numLeyendo = Seguimientos::find()->where(['libro_id'=>$id,'estado_id'=>2])->count();
                $numGustaría = Seguimientos::find()->where(['libro_id'=>$id,'estado_id'=>3])->count();
             ?>
            <p class="label label-primary"><?=$numLeido?> lo ha leido</p>
            <p class="label label-success"><?=$numLeyendo?> lo estan leyendo</p>
            <p class="label label-danger"><?=$numGustaría?> le gustaría leerlo</p>
            <p class="label label-warning">A <span id="seguidores">
                <?= Yii::$app->runAction('libros/consultaseguidores', ['libro_id' => $model->id]) ?>
            </span> persona(s) le(s) gusta </p>
        </div>
    </div>
    <?php if (!Yii::$app->user->isGuest) { ?>
    <div class="row">
        <div class="col-md-12 " style="text-align: center">
            <br><br>
                <?php
                $votante = Votos::find()->where(['usuario_id' => $usuarioId,
                                                 'libro_id' => $id])->one();
                if ($votante) {
                    $voto = $votante->voto;
                }else {
                    $voto = 0;
                }
            ?>
            <label class="control-label">Valora el libro:</label>
            <?= StarRating::widget(
                ['name' => 'rating',
                    'value' => $voto,
                    'pluginOptions' => [
                        'step' => 1 ]
                ]);
            ?>
        </div>
    </div>
        <div class="row" style="text-align: center">
            <?php $media = Yii::$app->runAction('libros/calculamediavotos',['libro_id' => $id])?>
            <p class="label label-info">Media:
                <h4 id="media">
                    <?= $media ?>
                </h4>
            </p>
        </div>
        <br>
        <br>
    <?php } ?>
</div>
<br>
<div class="col-md-9 ">
    <div class="row">
        <!-- Fila del libro donde está la información -->
        <div class="col-md-8 col-md-offset-2">
            <!-- Columna de 8 y separada 2 para la información principal-->
            <div class="panel panel-primary">
              <div class="panel-heading" style="text-align: center">
                  Información Principal
              </div>
              <div class="panel-body">
                  <p>Titulo: <?= $model->titulo ?></p>
                  <p>ISBN: <?= $model->isbn ?></p>
                  <p>Año: <?= $model->anyo ?></p>
                  <p>Sinopsis: <?= $model->sinopsis ?></p>
                  <p title="Enlace a compra">Compra: <?= Html::a('Compra', $model->url_compra) ?></p>
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

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <?php if (!Yii::$app->user->isGuest): ?>
        <?php
        $comentario = new Comentarios();
        $comentario->libro_id = $model->id;
        $comentario->usuario_id = Yii::$app->user->identity->id;
        $comentario->texto = '';
        $comentario->comentario_id = null;
        $form = ActiveForm::begin([
            'method' => 'POST',
            'action' => Url::to(['comentarios/create']),
            ]) ?>
            <?= $form->field($comentario, 'texto')->textarea()->label('Comentar') ?>
            <?= $form->field($comentario, 'comentario_id')->hiddenInput()->label(false) ?>
            <?= $form->field($comentario, 'libro_id')->hiddenInput()->label(false) ?>
            <?= $form->field($comentario, 'usuario_id')->hiddenInput()->label(false) ?>
            <button class="btn btn-xs btn-success" type="submit" name="button">Comentar</button>
        <?php ActiveForm::end() ?>

        <?php endif; ?>
    </div>
<br>
    <?php
    pintarComentarios($comentarios, $this);
    /**
     * Función para mostrar los comentarios de un libro
     * @param  array $comentarios Array de comentarios
     * @param   void $vista   Vista donde se van a mostrar los comentarios
     * @return void
     */
    function pintarComentarios($comentarios, $vista)
    {
        ?>
        <?php if ($comentarios) : ?>
            <ul>
            <?php foreach ($comentarios as $comentario) : ?>
                <div>
                    <?= $vista->render('/comentarios/_comentario',[
                        'model' => $comentario
                        ]) ?>
                    <?php pintarComentarios($comentario->comentariosHijos(), $vista)?>
                </div>
            <?php endforeach ?>
            </ul>
    <?php endif;
    }
    ?>

    <?php if (!Yii::$app->user->isGuest): ?>
        <!-- modal -->
        <?php $respuesta = new Comentarios([
            'usuario_id' => Yii::$app->user->identity->id,
            'libro_id' => $model->id
        ]);
        ?>

        <div class="modal fade" id="respuestaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Nueva respuesta</h4>
                    </div>
                    <div class="modal-body">
                        <?php $form = ActiveForm::begin([
                            'action' => Url::to(['comentarios/responder-comentario']),
                            ]) ?>
                        <?= $form->field($respuesta, 'libro_id')->hiddenInput()->label(false) ?>
                        <?= $form->field($respuesta, 'comentario_id')->hiddenInput(['class' => 'respuesta_id'])->label(false) ?>
                        <?= $form->field($respuesta, 'usuario_id')->hiddenInput()->label(false) ?>
                            <?= $form->field($respuesta, 'texto')->textarea()->label(false) ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Enviar respuesta</button>
                    </div>
                    <?php $form->end() ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php
    //JavaScript para meter el comentario_id a una respuesta
$js = <<<EOF
$('#respuestaModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var modal = $(this)
    modal.find('.respuesta_id').val(id)
})
EOF;
        $this->registerJs($js);
        ?>
</div>
