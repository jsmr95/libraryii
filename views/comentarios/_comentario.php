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
