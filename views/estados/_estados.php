<?php

use app\models\Usuarios;

use yii\helpers\Url;
use yii\helpers\Html;

?>
<style media="screen">
.cuerpo_estado {
    background-color: #e8edff;
    position: relative;
    padding: 5px 10px 5px 30px;
    margin: 20px 0px 20px 0px;
    border-radius: 6px;
    -webkit-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    -moz-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
}
.estado_texto {
    padding-top: 30px;
    padding-bottom: 50px;
    font-family: cursive;
}
#lyb{
    margin-left: 30px;
}
#lyb > button{
    width: 70px;
}
.botonLyb{
    color: green;
}
</style>
<?php
//Variables que voy a usar
$id = $model->id;
$usuarioId = Yii::$app->user->id;
// $fila = LibrosFavs::find()->where(['usuario_id' => $id])->one();
$url = Url::to(['estados-lyb/create']);
$followJs = <<<EOT

function hacerLyb(event){
    var estado_id = event.target.attributes['data-id'].nodeValue;
    $.ajax({
        url: '$url',
        data: { usuario_id: '$usuarioId',
                estado_id: estado_id},
        success: function(data){
            if (data > 0) {
                $(event.target).attr('data-id') == data ? $(event.target).addClass('botonLyb') : '';
            }else {
                $(event.target).removeClass('botonLyb');
            }
        }
    });
}

$(document).ready(function(){
    $('#lybrear$id').click(hacerLyb);
});
EOT;
$this->registerJs($followJs);
?>
<?php
$usua = Usuarios::findOne(['id' => $model->usuario->id]);
if ($usua) {
    ?>
<div class="row ">
    <div class="cuerpo_estado col-md-12">
        <div class=" col-md-2">
            <!-- Imagen AQUI -->
            <center>
                <p>
                    <?php
                    if (empty($model->imagen)) {
                        echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg');
                    } else {
                        echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen);
                    }
                    ?>
                </p>
            </center>
        </div>
        <div class=" col-md-7">
        <span>
            <h2>
                <?= Html::a(
                    $usua->nombre,
                    ['usuarios/view',
                        'id' => $model->usuario->id
                    ]) ?>
                <small style="font-size: 12px;">
                    <?= Yii::$app->formatter
                        ->asRelativeTime($model->created_at)
                    ?>
                </small>
            </h2>
        </span>
            <p class="estado_texto">
                <?= $model->estado  ?>
            </p>
            <p  id="lyb">
                <button id="lybrear<?=$id?>"
                    class="<?= $model->consultaLyb($usuarioId, $id) ? "botonLyb" : ""; ?>"
                    data-id="<?= $id ?>">
                    <span class='glyphicon glyphicon-retweet' aria-hidden='true'></span>
                </button>
            </p>
        </div>
    </div>

</div>
<?php } ?>
