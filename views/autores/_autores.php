<?php
use yii\helpers\Html;

?>
<style media="screen">
.right{
    float: right;
    margin-top: 7px;
}
.autor {
    padding: 23px;
}
.autor-cuerpo {
    background-color: #e8edff;
    position: relative;
    padding: 5px 10px 5px 30px;
    border-radius: 6px;
    -webkit-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    -moz-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);

}
.autor-texto {
    padding-top: 30px;
    padding-bottom: 50px;
    font-family: cursive;
}
</style>
<div class="row autor">
    <div class="autor-cuerpo col-md-12">
        <div class="autor-cuerpo col-md-3">
            <!-- Imagen AQUI -->
            <center>
                <p>
                    Aqui va la imagen!
                </p>
            </center>
        </div>
        <div class=" col-md-7">
            <h2>
                <?= Html::a($model->nombre, ['autores/view', 'id' => $model->id]) ?>
            </h2>
            <p class="autor-texto">
                <?= $model->descripcion  ?>
            </p>
        </div>
    </div>

</div>
