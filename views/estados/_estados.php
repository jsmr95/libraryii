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
</style>
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
                <?php
                $usua = Usuarios::findOne(['id' => $model->usuario->id]);
                //var_dump($usua); die();
                ?>
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
