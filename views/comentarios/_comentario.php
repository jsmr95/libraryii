<?php
use yii\helpers\Html;
?>
<style media="screen">
.right{
    float: right;
    margin-top: 7px;
}
.comentario {
    padding: 17px;
}
.comentario-cuerpo {
    background-color: #e8edff;
    position: relative;
    padding: 5px 10px 5px 30px;
    border-radius: 6px;
    -webkit-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    -moz-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
}
.comentario-texto {
    padding-left: 10px;
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
<div class="row comentario">
    <div class="comentario-cuerpo col-md-11">
        <div class="comentario-cabecera">
            <h4>
                <?= Html::a($model
                ->usuario
                ->usuarios
                ->login, [
                    'usuarios/view',
                    'id' => $model->usuario->usuarios->id
                    ]) ?>
                    <small>
                    <?= Yii::$app
                    ->formatter
                    ->asRelativeTime($model->created_at) ?>
                </small>
                <?php
                    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login === 'admin'){

                echo Html::a( "<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>",
                [ 'comentarios/delete', 'id' => $model->id, 'libro_id' => $model->libro_id ],
                [ 'data' =>
                    [
                        'method' => 'POST',
                        'confirm' => "¿Seguro que quieres eliminar este comentario?"
                    ]
                ]);
                    }
                ?>
            </h4>
        </div>
        <div class="comentario-texto">
            <?= $model->texto  ?>
        </div>
    </div>

    <div class="">

    <?php if (!Yii::$app->user->isGuest && $model->comentario_id == null): ?>
        <div class="contestar col-md-offset-10 col-md-1">
            <?= Html::button('Contestar', [
                'class' => 'btn btn-primary btn-xs',
                'data-toggle' => 'modal',
                'data-target' => '#respuestaModal',
                'data-id' => $model->id,
                ]) ?>
        </div>
    <?php endif; ?>
    </div>
</div>
