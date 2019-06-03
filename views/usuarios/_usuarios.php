<?php
use yii\helpers\Html;

?>
<style media="screen">
.right{
    float: right;
    margin-top: 7px;
}

.usuario-cuerpo {
    background-color: #ffe6cc;
    position: relative;
    padding: 5px 0px 5px 0px;
    border-radius: 45px;
    -webkit-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    -moz-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    margin-bottom: 40px;
    margin-top: 40px;
    width: 230px;
    margin-right: 55px;
}

img.usuarios {
    width: 140px !important;
    height: 160px !important;
    border-radius: 50px ;
}
.dropdown-menu > li {
    cursor:pointer;
}
.glyphicon-trash {
    color:red;
    font-size: 20px !important;
}
.glyphicon-trash:hover {
    color:blue;
    font-size: 18px !important;
}
</style>

<div class="col-md-3 usuario-cuerpo ">
    <!-- Columna completa de cada libro-->
    <!-- Columna de 3 para la imagen del libro-->
    <center>
        <p>
            <?php
            if (empty($model->url_avatar)) {
                echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg', ['class' => 'usuarios']);
            } else {
                echo Html::img(Yii::getAlias('@uploads').'/'.$model->url_avatar, ['class' => 'usuarios']);
            }
            ?>
        </p>
        <h3>
            <?= Html::a($model->login, [
            'usuarios/view',
            'id' => $model->id
            ])
            ?>
            <?php
                if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login === 'admin'){

                    echo Html::a( "<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>",
                    [ 'usuarios/delete', 'id' => $model->id ],
                    [ 'data' =>
                        [
                            'method' => 'POST',
                            'confirm' => "¿Seguro que quieres eliminar al usuario $model->login?"
                        ]
                    ]);
                    ?>
        <small>
            <?php
                if ($model->banned_at == null) {
                    echo Html::a(
                        'Banear',
                        ['usuarios/banear', 'id' => $model->id],
                        [
                            'data-method' => 'POST',
                            'data-confirm' => '¿Seguro que desea banear a ese usuario?'
                        ]
                    );
                } else {
                    echo Html::a(
                        'Desbanear',
                        ['usuarios/desbanear', 'id' => $model->id],
                        [
                            'data-method' => 'POST',
                            'data-confirm' => '¿Seguro que desea desbanear a ese usuario?'
                        ]
                    );
                }
                }
            ?>
        </small>
    </h3>
    </center>


</div>
