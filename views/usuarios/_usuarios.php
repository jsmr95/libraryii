<?php
use yii\helpers\Html;

?>
<style media="screen">
.right{
    float: right;
    margin-top: 7px;
}

.usuario-cuerpo {
    background-color: #e8edff;
    position: relative;
    padding: 5px 10px 5px 30px;
    border-radius: 15px;
    -webkit-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    -moz-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    margin-right: 80px;
    margin-bottom: 40px;
    margin-top: 40px;
}

img.usuarios {
    width: 190px !important;
    height: 225px !important;
    border-radius: 50px ;
}
.dropdown-menu > li {
    cursor:pointer;
}
</style>

<div class="col-md-3 usuario-cuerpo ">
    <!-- Columna completa de cada libro-->
    <!-- Columna de 3 para la imagen del libro-->
    <center>
        <p>
            <?php
            if (empty($model->imagen)) {
                echo Html::img(Yii::getAlias('@uploads').'/userAutorDefecto.jpeg', ['class' => 'usuarios']);
            } else {
                echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'usuarios']);
            }
            ?>
        </p>
        <h3>
            <?= Html::a($model->login, [
            'usuarios/view',
            'id' => $model->id
            ])
            ?>
    </h3>
    </center>


</div>
