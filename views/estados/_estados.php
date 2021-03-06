<?php

use app\models\Libros;
use app\models\Usuarios;

use yii\data\ActiveDataProvider;

use yii\helpers\Url;
use yii\helpers\Html;

use yii\widgets\ListView;

?>
<style  >
.cuerpo_estado {
    background-color: #ffe6cc;
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
    background-color: #ffe6cc;
}
#lyb > button{
    width: 70px;
    background-color: #ffe6cc;
    padding: 0;
    border: none;
    background: none;
}
.botonLyb{
    color: green;
}
img.usuarios {
    width: 130px !important;
    height: 150px !important;
    border-radius: 70px ;
    margin-top: 30px !important;
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
<?php
//Variables que voy a usar
$id = $model->id;
$usuarioId = Yii::$app->user->id;
$corazon = $model->consultaFav($usuarioId,$id);
$url1 = Url::to(['estados-lyb/create']);
$url2 = Url::to(['estados-favs/create']);
$followJs = <<<EOT

function hacerLyb(event){
    var estado_id = event.target.attributes['data-lyb'].nodeValue;
    $.ajax({
        url: '$url1',
        data: { usuario_id: '$usuarioId',
                estado_id: estado_id},
        success: function(data){
            if (data > 0) {
                $(event.target).attr('data-lyb') == data ? $(event.target).addClass('botonLyb') : '';
            }else {
                $(event.target).removeClass('botonLyb');
            }
        }
    });
}

function hacerFav(event){
    var estado_id = event.target.attributes['data-fav'].nodeValue;
    $.ajax({
        url: '$url2',
        data: { usuario_id: '$usuarioId',
                estado_id: estado_id},
        success: function(data){
            if (data == '') {
                $(event.target).find('span').removeClass('glyphicon-heart-empty');
                $(event.target).find('span').addClass('glyphicon-heart');
            } else {
                $(event.target).find('span').removeClass('glyphicon-heart');
                $(event.target).find('span').addClass('glyphicon-heart-empty');
            }
        }
    });
}

$(document).ready(function(){
    $('#lybrear$id').click(hacerLyb);
    $('#favear$id').click(hacerFav);
});
EOT;
$this->registerJs($followJs);
?>
<?php
$usua = Usuarios::findOne(['id' => $model->usuario->id]);
if ($usua) {
    ?>
<div class="row ">
    <div class="cuerpo_estado col-md-12 ">
        <div class=" col-md-2" style="text-align: center">
            <!-- Imagen AQUI -->
            <p>
                <?php
                if (empty($usua->url_avatar)) {
                    echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg', ['class' => 'usuarios']);
                } else {
                    echo Html::img(Yii::getAlias('@uploads').'/'.$usua->url_avatar, ['class' => 'usuarios']);
                }
                ?>
            </p>
        </div>
        <div class=" col-md-7 ">
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
                <?php
                    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login === 'admin'){

                echo Html::a( "<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>",
                [ 'estados/delete', 'id' => $model->id ],
                [ 'data' =>
                    [
                        'method' => 'POST',
                        'confirm' => "¿Seguro que quieres eliminar este estado?"
                    ]
                ]);
                    }
                ?>
            </h2>
        </span>
            <p class="estado_texto">
                <?= $model->estado  ?>
            </p>
            <p  id="lyb">
                <button id="lybrear<?=$id?>"
                    class="<?= $model->consultaLyb($usuarioId, $id) ? "botonLyb" : ""; ?>"
                    data-lyb="<?= $id ?>"
                    title="Hacer Lyb">
                    <span class='glyphicon glyphicon-retweet' aria-hidden='true'></span>
                </button>
                <button id="favear<?=$id?>" data-fav="<?= $id ?>" title="Me gusta">
                    <span style="color:red" id="corazon" class='glyphicon glyphicon-heart<?=$corazon?>' aria-hidden='true'></span>
                </button>
            </p>
        </div>
        <?php if ($model->libro_id != '' || $model->libro_id != null) { ?>
        <div class="col-md-2 col-md-offset-1 " style="text-align: center">
            <?php
            $dataProvider = new ActiveDataProvider([
                'query' => Libros::find()->where(['id' =>$model->libro_id])
            ]);
            echo ListView::widget([
              'dataProvider' => $dataProvider,
              'summary' => '',
              'itemView' => '_libroReferencia',
          ]); ?>
        </div>
    <?php } ?>
    </div>
</div>

<?php } ?>
