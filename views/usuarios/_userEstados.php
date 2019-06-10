<?php

use app\models\Libros;
use app\models\Usuarios;

use yii\data\ActiveDataProvider;

use yii\helpers\Url;
use yii\helpers\Html;

use yii\widgets\ListView;

?>
<style media="screen">
.cuerpo_estado {
    background-color: #ffe6cc;
    position: relative;
    padding: 0px 10px 0px 30px;
    margin: 10px 0px 10px 40px;
    border-radius: 6px;
    -webkit-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    -moz-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
}
.estado_texto {
    padding-top: 10px;
    padding-bottom: 10px;
    font-family: cursive;
}
img.imgEstados {
    width: 70px !important;
    height: 95px !important;
    border-radius: 110px;
    margin-top:10px;
    margin-left: -20px;
}
img.librosUsuariosPerfil {
    width: 50px !important;
    height: 60px !important;
    border-radius: 3px;
    margin-top: 25px !important;
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
    <div class=" col-md-10  cuerpo_estado">
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
        <div class=" col-md-8 ">
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
        <?php if ($model->libro_id != '' || $model->libro_id != null) { ?>
        <div class="col-md-2 ">
            <center>
                <?php
                $dataProvider = new ActiveDataProvider([
                    'query' => Libros::find()->where(['id' =>$model->libro_id])
                ]);
                echo ListView::widget([
                  'dataProvider' => $dataProvider,
                  'summary' => '',
                  'itemView' => '_libroReferencia',
              ]); ?>
            </center>
        </div>
    <?php } ?>
    </div>
</div>


<?php } ?>
