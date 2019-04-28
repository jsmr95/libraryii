<?php

use app\models\Libros;
use app\models\Usuarios;
use app\models\LibrosFavs;
use app\models\EstadoPersonal;

use yii\data\ActiveDataProvider;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->nombre . ' ' . $model->apellido;
$this->params['breadcrumbs'][] = ['label' => 'Social', 'url' => ['estados/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>

img.usuarios {
    width: 190px !important;
    height: 225px !important;
    border-radius: 110px;
}
span.glyphicon {
    color:red;
}

#inputEstadoPersonal {
    border: none;
    width: 500px;
    text-align: center;
    margin-top: 15px;
}

</style>
<div class="container">
    <!--Contenedor para el libro -->
    <?php
    //Variables que voy a usar
    $id = $model->id;
    $usuarioId = Yii::$app->user->id;
    $fila = LibrosFavs::find()->where(['usuario_id' => $id])->one();
    $corazon = $model->consultaSeguidor( $usuarioId, $model->id);
    $url1 = Url::to(['users-favs/create']);
    $url2 = Url::to(['estado-personal/create']);
    $followJs = <<<EOT

    function seguir(event){
        $.ajax({
            url: '$url1',
            data: { usuario_fav: '$id'},
            success: function(data){
                if (data == '') {
                    $('#corazon').removeClass('glyphicon-heart-empty');
                    $('#corazon').addClass('glyphicon-heart');
                } else {
                    $('#corazon').removeClass('glyphicon-heart');
                    $('#corazon').addClass('glyphicon-heart-empty');
                }
            }
        });
    }

    function cambiarEstado(event){
        var content = $('#inputEstadoPersonal').val();
        $.ajax({
            url: '$url2',
            data: { usuario_id: '$usuarioId',
                    contenido: content
                },
        });
    }

    $(document).ready(function(){
        $('.follow').click(seguir);
        $('#inputEstadoPersonal').change(cambiarEstado);
    });
EOT;
$this->registerJs($followJs);
    ?>
    <!-- Nombre y corazón para saber si lo sigo-->
    <center>
        <h1>
            <?= Html::encode($this->title)?>
            <?php
            if ($usuarioId != $model->id && !Yii::$app->user->isGuest) { ?>
                <button class="follow">
                    <span id="corazon" class='glyphicon glyphicon-heart<?=$corazon?>' aria-hidden='true'></span>
                </button>
            <?php } ?>
        </h1>
    </center>

    <?php
    if (!Yii::$app->user->isGuest){
        if (Yii::$app->user->identity->login === $model->login){
            ?>
<div class="row">
    <!-- Fila para mostrar las opciones de un administrador-->
    <div class="col-md-offset-5 col-md-2">
    <p>
        <?= Html::a('Modificar', ['update', 'id' => $id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar cuenta', ['delete', 'id' => $id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estás seguro que desea eliminar su cuenta? Se eliminará TODO su contenido registrado!',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
</div>
<?php } }  ?>
<div class="row">
    <!-- Fila para el usuario-->
    <div class="row">
        <div class="col-md-offset-5 col-md-2">
            <!-- Columnna de 5 y separada 2 para la imagen del usuario y estado personal -->
            <br>
            <?php
            if (empty($model->url_avatar)) {
                echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg', ['class' => 'usuarios']);
            } else {
                echo Html::img(Yii::getAlias('@uploads').'/'.$model->url_avatar, ['class' => 'usuarios']);
            }
            ?>
        </div>
    </div>

    <!-- Obtengo el estado personal del usuario -->
    <?php
    if (!Yii::$app->user->isGuest){
        ?>
    <div class="row">
        <div class="col-md-12">
            <center>
                <p style="font-style: italic;">
                    <?php
                    $estado = EstadoPersonal::find()
                        ->where(['usuario_id' => $id])->one();
                    if ($estado) {
                        if ($usuarioId === $id) { ?>

                        '<?= Html::textInput('contenido',$estado->contenido,
                        [
                            'id' => 'inputEstadoPersonal',
                        ]);  ?>'
                    <?php } else { ?>
                        '<?= Html::encode($estado->contenido) ?>'
                    <?php } ?>
                <?php } else { ?>
                    'Estado Personal'
                <?php } ?>
                </p>
            </center>
        </div>
    </div>
    <?php } ?>
</div>
<br>
<br>
<div class="row">
    <!-- Fila para saber los libro que sigue el usuario-->
    <div class="col-md-2">
        <!-- Columna de 2-->
        <div class="panel panel-primary">
            <div class="panel-heading">Libros que sigue...</div>
            <div class="panel-body">
                <?php
                $dataProvider = new ActiveDataProvider([
                    'query' => Libros::find()
                    ->joinWith('librosFavs')
                    ->where(['usuario_id' => $model->id]),
                ]);
                echo ListView::widget([
                  'dataProvider' => $dataProvider,
                  'summary' => '',
                  'itemView' => '_librosFavs',
              ]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <!-- Columna de 8 para la Info de la cuenta-->
        <div class="panel panel-primary">
          <div class="panel-heading">Información Cuenta</div>
          <div class="panel-body">
              <p>Login: <?= $model->login ?></p>
              <p>Email: <?= $model->email ?></p>
          </div>
        </div>
    </div>
    <div class="col-md-8 <?php if (!$fila){ echo 'col-md-offset-2';}?>">
        <!-- Columna de 8 para la info personal, tendrá 2 de separación dependiendo si tiene o no libros siguiendo-->
        <div class="panel panel-primary">
          <div class="panel-heading">Información Personal</div>
          <div class="panel-body">
              <p>Nombre: <?= $model->nombre ?></p>
              <p>Apellido: <?= $model->apellido ?></p>
              <p>Biografía: <?= $model->biografia ?></p>
              <p>Autenticado: <?php
               if (empty($model->auth_key)) {?>
                   Verificado!
               <?php } else {?>
               NO verificado!
               <?php } ?>
               </p>
              <p>Creado: <?= $model->created_at ?></p>
              <p>Última modificación: <?= $model->updated_at ?></p>
          </div>
        </div>
    </div>
</div>

</div>
