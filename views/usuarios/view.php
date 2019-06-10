<?php

use app\models\Libros;
use app\models\Estados;
use app\models\Usuarios;
use app\models\LibrosFavs;
use app\models\EstadoPersonal;

use yii\data\ActiveDataProvider;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\DetailView;

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->nombre . ' ' . $model->apellido;
$this->params['breadcrumbs'][] = ['label' => 'Social', 'url' => ['estados/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
#items{
    list-style: none;
    margin:0px;
    margin-top:4px;
    padding-left: 10px;
    padding-right: 10px;
    padding-bottom: 3px;
    font-size: 17px;
    color: #333333;
}
#menu{
    z-index: 9999 !important;
    display:none;
    position:fixed;
    border:1px solid #B2B2B2;
    width: auto;
    background: #F9F9F9;
    box-shadow: 3px 3px 2px #E9E9E9;
    border-radius: 4px;
}
li {
    padding: 3px;
    padding-left: 10px;
}
#items:hover {
    color:white;
    background: #284570;
    border-radius: 2px;
}

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
    background-color: #fff2e6;
}

button.follow {
    padding: 0;
    border: none;
    background: none;
}

</style>
    <!--Contenedor para el libro -->
    <?php
    //Variables que voy a usar
    $id = $model->id;
    $usuarioId = Yii::$app->user->id;
    $fila = LibrosFavs::find()->where(['usuario_id' => $id])->one();
    $corazon = $model->consultaSeguidor( $usuarioId, $model->id);
    $url1 = Url::to(['users-favs/create']);
    $url2 = Url::to(['estado-personal/create']);
    $url3 = Url::to(['usuarios/consultaseguidores']);
    $url4 = Url::to(['usuarios/guardacookie']);
    $url5 = Url::to(['usuarios/obtenercookie']);
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
                $.ajax({
                    url: '$url3',
                    data: { usuario_id: '$id'},
                    success: function(data){
                        console.log(data);
                        $('#seguidores')[0].firstChild.nodeValue = data;
                    }
                });
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

    function cambiarColorYGuardaCookie(){
        var color = $("#pickerColor").val();
        $(".panel-heading").css('background-color', color);
        $.ajax({
            url: '$url4',
            data: { color: color },
            success: function(data){
                console.log(data);
            }
        });
    }

    function obtenerCookie(){
        $.ajax({
            url: '$url5',
            success: function(data){
                $(".panel-heading").css('background-color', data);
            }
        });
    }

    $(document).ready(function(){
        obtenerCookie();
        $('.follow').click(seguir);
        $('#inputEstadoPersonal').change(cambiarEstado);

        //Función para cambiar de pestañas
        $('#myTabs a').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
        });

        //Función para cambiar de color el panel-heading
        $('.panel-heading').contextmenu(function(e){
            e.preventDefault();

            if ($("#menu").css('display') == 'block') {
                $("#menu").hide();
                return;
            }

            $("#menu").css("left", e.clientX);
            $("#menu").css("top", e.clientY);
            $("#menu").fadeIn(200);
            $('#pickerColor').change(function(){
                $("#menu").hide();
                cambiarColorYGuardaCookie();
            });
        });

    });
EOT;
$this->registerJs($followJs);
    ?>
<!-- Menú -->
<div id="menu">
    <ul id="items">
        <li><input type="color" id="pickerColor">Cambiar color</li>
    </ul>
</div>
<div class="col-md-3">
    <div class="row">
        <div class="col-md-8 col-md-offset-4" >

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

        <?php
        if (!Yii::$app->user->isGuest){
            if (Yii::$app->user->identity->login === $model->login){
                ?>

        <!-- Fila para mostrar las opciones de un administrador-->
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

        <?php } }  ?>
        <!-- Fila para el usuario-->

        <!-- Columnna de 5 y separada 2 para la imagen del usuario y estado personal -->
        <br>
        <?php
        if (empty($model->url_avatar)) {
            echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg', ['class' => 'usuarios']);
        } else {
            echo Html::img(Yii::getAlias('@uploads').'/'.$model->url_avatar, ['class' => 'usuarios']);
        }
        ?>
    </center>
        <!-- Obtengo el estado personal del usuario -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12  ">

        <?php
        if (!Yii::$app->user->isGuest){
            ?>
        <center>
            <p style="font-style: italic; margin-top: 25px" title="Estado personal">
                <?php
                $estado = EstadoPersonal::find()
                    ->where(['usuario_id' => $id])->one();
                if ($estado) {
                    if ($usuarioId === $id) { ?>

                    <?= Html::textInput('contenido',$estado->contenido,
                    [
                        'id' => 'inputEstadoPersonal',
                    ]);  ?>
                <?php } else { ?>
                    '<?= Html::encode($estado->contenido) ?>'
                <?php } ?>
            <?php } else if ($usuarioId === $id) { ?>
                <?= Html::textInput('contenido','Estado Personal',
                [
                    'id' => 'inputEstadoPersonal',
                ]);  ?>
            <?php } else { ?>
                'Estado Personal'
            <?php } ?>
            </p>
        </center>
        <?php } ?>
        <br>
        <center>
            <span class="label label-primary">Seguidores:
                <span id="seguidores" >
                <?= Yii::$app->runAction('usuarios/consultaseguidores', ['usuario_id' => $model->id]) ?>
                </span>
            </span>
            <br>
            <span class="label label-success">
            Siguiendo: <?= $model->consultaSiguiendo($model->id) ?></span>
        </center>
        <br>

        </div>
    </div>
</div>


<div class="col-md-9 ">
    <div class="row">

        <!-- PANEL CENTRAL -->
        <div class="col-md-9 col-md-offset-1 col-xs-12">
            <!-- Columna de 8 para la Info de la cuenta-->
            <ul class="nav nav-tabs" role="tablist" id="myTabs">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Información</a></li>
                <li role="presentation"><a href="#misPosts" aria-controls="misPosts" role="tab" data-toggle="tab">Posts</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Me gustan</a></li>
                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Lybs</a></li>
                <li role="presentation"><a href="#leyendo" aria-controls="leyendo" role="tab" data-toggle="tab">Leyendo</a></li>
                <li role="presentation"><a href="#leer" aria-controls="leer" role="tab" data-toggle="tab">Por leer</a></li>
                <li role="presentation"><a href="#leidos" aria-controls="leidos" role="tab" data-toggle="tab">Leidos</a></li>
            </ul>
            <div class="tab-content ">
                <div role="tabpanel" class="tab-pane fade in active" id="home">
                    <div class="panel panel-primary ">
                      <div class="panel-heading">Información Cuenta</div>
                          <div class="panel-body">
                              <p><strong>Login:</strong> <?= $model->login ?></p>
                              <p><strong>Email:</strong> <?= $model->email ?></p>
                          </div>
                    </div>
                    <!-- Columna de 8 para la info personal, tendrá 2 de separación dependiendo si tiene o no libros siguiendo-->
                    <div class="panel panel-primary">
                      <div class="panel-heading">Información Personal</div>
                      <div class="panel-body">
                          <p><strong>Nombre:</strong> <?= $model->nombre ?></p>
                          <p><strong>Apellido:</strong> <?= $model->apellido ?></p>
                          <p><strong>Biografía:</strong> <?= $model->biografia ?></p>
                          <p><strong>Autenticado:</strong> <?php
                           if (empty($model->auth_key)) {?>
                               Verificado!
                           <?php } else {?>
                           NO verificado!
                           <?php } ?>
                           </p>
                          <p><strong>Creado:</strong> <?= $model->created_at ?></p>
                          <p><strong>Última modificación:</strong> <?= $model->updated_at ?></p>
                      </div>
                    </div>
                </div><!-- Final PANEL DE INFORMACION -->
                <div role="tabpanel" class="tab-pane fade" id="misPosts">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Posts del usuarios...</div>
                        <div class="panel-body">
                            <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => Estados::find()
                                ->where(['usuario_id' => $model->id]),
                            ]);
                            $dataProvider->setSort([
                                'defaultOrder' => ['created_at' => SORT_DESC],
                            ]);
                            $dataProvider->pagination = ['pageSize' => 5];
                            Pjax::begin();
                            echo ListView::widget([
                              'dataProvider' => $dataProvider,
                              'summary' => '',
                              'itemView' => '_userEstados',
                              'layout' => '{items}
                              <center>
                                  <div class="row">
                                      <div class="col-md-12 col-lg-12 col-xs-12">
                                          {pager}
                                      </div>
                                  </div>
                              </center>
                              ',
                          ]);
                          Pjax::end();
                          ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="profile">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Estados que me gustan...</div>
                        <div class="panel-body">
                            <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => Estados::find()
                                ->joinWith('estadosFavs')
                                ->where(['estados_favs.usuario_id' => $model->id]),
                            ]);
                            $dataProvider->setSort([
                                'defaultOrder' => ['created_at' => SORT_DESC],
                            ]);
                            $dataProvider->pagination = ['pageSize' => 5];
                            Pjax::begin();
                            echo ListView::widget([
                              'dataProvider' => $dataProvider,
                              'summary' => '',
                              'itemView' => '_userEstados',
                              'layout' => '{items}
                              <center>
                                  <div class="row">
                                      <div class="col-md-12 col-lg-12 col-xs-12">
                                          {pager}
                                      </div>
                                  </div>
                              </center>
                              ',
                          ]);
                          Pjax::end();
                          ?>
                        </div>
                    </div>
                </div><!-- FIN PANEL ME GUSTAN -->
                <div role="tabpanel" class="tab-pane fade" id="messages">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Estados lybreados...</div>
                        <div class="panel-body">
                            <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => Estados::find()
                                ->joinWith('estadosLybs')
                                ->where(['estados_lyb.usuario_id' => $model->id]),
                            ]);
                            $dataProvider->setSort([
                                'defaultOrder' => ['created_at' => SORT_DESC],
                            ]);
                            $dataProvider->pagination = ['pageSize' => 5];

                            Pjax::begin();
                            echo ListView::widget([
                              'dataProvider' => $dataProvider,
                              'summary' => '',
                              'itemView' => '_userEstados',
                              'layout' => '{items}
                              <center>
                                  <div class="row">
                                      <div class="col-md-12 col-lg-12 col-xs-12">
                                          {pager}
                                      </div>
                                  </div>
                              </center>
                              ',
                          ]);
                          Pjax::end();
                          ?>
                        </div>
                    </div>
                </div><!-- FIN PANEL MIS LYBS -->
                <div role="tabpanel" class="tab-pane fade" id="leyendo">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Libros en 'leyendo'</div>
                        <div class="panel-body">
                            <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => Libros::find()
                                ->joinWith('seguimientos')
                                ->where(['seguimientos.usuario_id' => $model->id, 'estado_id' => 2]),
                            ]);
                            $dataProvider->pagination = ['pageSize' => 5];

                            Pjax::begin();
                            echo ListView::widget([
                              'dataProvider' => $dataProvider,
                              'summary' => '',
                              'itemView' => '_librosFavs',
                              'layout' => '{items}
                              <center>
                                  <div class="row">
                                      <div class="col-md-12 col-lg-12 col-xs-12">
                                          {pager}
                                      </div>
                                  </div>
                              </center>
                              ',
                          ]);
                          Pjax::end();
                          ?>
                        </div>
                    </div>
                </div><!-- FIN PANEL MIS Leyendo -->
                <div role="tabpanel" class="tab-pane fade" id="leer">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Libros en 'Me gustaría leer'</div>
                        <div class="panel-body">
                            <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => Libros::find()
                                ->joinWith('seguimientos')
                                ->where(['seguimientos.usuario_id' => $model->id, 'estado_id' => 3]),
                            ]);
                            $dataProvider->pagination = ['pageSize' => 5];

                            Pjax::begin();
                            echo ListView::widget([
                              'dataProvider' => $dataProvider,
                              'summary' => '',
                              'itemView' => '_librosFavs',
                              'layout' => '{items}
                              <center>
                                  <div class="row">
                                      <div class="col-md-12 col-lg-12 col-xs-12">
                                          {pager}
                                      </div>
                                  </div>
                              </center>
                              ',
                          ]);
                          Pjax::end();
                          ?>
                        </div>
                    </div>
                </div><!-- FIN PANEL MIS Por leer -->
                <div role="tabpanel" class="tab-pane fade" id="leidos">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Libros leídos</div>
                        <div class="panel-body">
                            <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => Libros::find()
                                ->joinWith('seguimientos')
                                ->where(['seguimientos.usuario_id' => $model->id, 'estado_id' => 1]),
                            ]);
                            $dataProvider->pagination = ['pageSize' => 5];

                            Pjax::begin();
                            echo ListView::widget([
                              'dataProvider' => $dataProvider,
                              'summary' => '',
                              'itemView' => '_librosFavs',
                              'layout' => '{items}
                              <center>
                                  <div class="row">
                                      <div class="col-md-12 col-lg-12 col-xs-12">
                                          {pager}
                                      </div>
                                  </div>
                              </center>
                              ',
                          ]);
                          Pjax::end();
                          ?>
                        </div>
                    </div>
                </div><!-- FIN PANEL MIS Leidos -->
            </div>
        </div>

    </div>
</div>

<!-- Fila para saber los libro que sigue el usuario-->
<div class="row">
    <div class="col-md-10  col-md-offset-1 ">
        <!-- Columna de 10-->
        <div class="panel panel-primary">
            <div class="panel-heading">Libros favoritos</div>
            <div class="panel-body">
                <?php
                $query = Libros::find()
                ->joinWith('librosFavs')
                ->Where("libros.id IN (SELECT id FROM libros WHERE autor_id IN (SELECT autor_id FROM autores_favs WHERE autores_favs.usuario_id = $model->id))")
                ->orWhere(['usuario_id' => $model->id]);
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                ]);

                $dataProvider->pagination = ['pageSize' => 6];

                Pjax::begin();
                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'itemView' => '_librosFavs',
                    'layout' => '{items}
                    <center>
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xs-12">
                                {pager}
                            </div>
                        </div>
                    </center>
                    ',
                ]);
                Pjax::end();
                ?>
            </div>
        </div>
    </div>
</div>
