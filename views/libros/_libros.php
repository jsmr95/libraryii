<?php
use yii\helpers\Html;

?>
<style media="screen">
.right{
    float: right;
    margin-top: 7px;
}
.libro {
    padding: 17px;
}
.libro-cuerpo {
    background-color: #e8edff;
    position: relative;
    padding: 5px 10px 5px 30px;
    border-radius: 6px;
    -webkit-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    -moz-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
}
.libro-texto {
    padding-top: 55px;
    font-family: cursive;
}
img.libros {
    width: 190px !important;
    height: 225px !important;
}
</style>
<div class="row libro">
    <!-- Fila para cada libro-->
    <div class="col-md-12 libro-cuerpo ">
        <!-- Columna completa de cada libro-->
        <div class="col-md-3">
            <!-- Columna de 3 para la imagen del libro-->
            <center>
                <p>
                    <?php
                    if (empty($model->imagen)) {
                        echo Html::img(Yii::getAlias('@uploads').'/libroDefecto.png', ['class' => 'libros']);
                    } else {
                        echo Html::img(Yii::getAlias('@uploads').'/'.$model->imagen, ['class' => 'libros']);
                    }
                    ?>
                </p>
            </center>
        </div>
        <div class="col-md-4 libro-cabecera ">
            <!-- Columna de 4 para la info de cada libro -->
            <p>
                <h2>
                    <?= Html::a($model->titulo, [
                    'libros/view',
                    'id' => $model->id
                    ]) ?>
                    <!-- Botón para seguimiento -->
                    <span class="dropdown">
                      <button style="margin-left:20px" class="btn btn-default dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        ...
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#">Leído</a></li>
                        <li><a href="#">Leyendo</a></li>
                        <li><a href="#">Me gustaría leerlo</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Limpiar seguimiento</a></li>
                      </ul>
                  </span>
                </h2>

                <ul>
                    <li>Autor: <?= Html::a($model->autor->nombre, ['autores/view', 'id' => $model->autor->id]) ?></li>
                    <li>Año: <?= $model->anyo ?></li>
                    <li>Género: <?= $model->genero->genero ?></li>
                    <li>ISBN: <?= $model->isbn ?></li>
                    <li> <?= Html::a('Compra', $model->url_compra) ?>
                    </li>
                </ul>
            </p>

        </div>
        <div class="col-md-5 libro-texto ">
            <!-- Columna de 5 para la sinopsis-->
            <?= $model->sinopsis  ?>
        </div>
    </div>

</div>
