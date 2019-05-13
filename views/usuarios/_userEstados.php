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
    margin: 20px 0px 20px 40px;
    border-radius: 6px;
    -webkit-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    -moz-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
}
.estado_texto {
    padding-top: 20px;
    padding-bottom: 30px;
    font-family: cursive;
}
img.imgEstados {
    width: 100px !important;
    height: 125px !important;
    border-radius: 110px;
    margin-left: -20px;
}
</style>
<?php
//Variables que voy a usar
$id = $model->id;
$usuarioId = Yii::$app->user->id;
?>
<?php
$usua = Usuarios::findOne(['id' => $model->usuario->id]);
if ($usua) {
    ?>

<div class="row ">
    <div class=" col-md-10 cuerpo_estado">
        <div class=" col-md-2">
            <!-- Imagen AQUI -->
            <center>
                <p>
                    <?php
                    if (empty($model->imagen)) {
                        echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg',['class' => 'imgEstados']);
                    } else {
                        echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen,['class' => 'imgEstados']);
                    }
                    ?>
                </p>
            </center>
        </div>
        <div class=" col-md-8">
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
        </div>
    </div>
</div>


<?php } ?>
