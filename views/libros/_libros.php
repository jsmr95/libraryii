<?php
use yii\helpers\Url;
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

<?php
$url1 = Url::to(['seguimientos/create']);

$id = $model->id;
$usuarioId = Yii::$app->user->id;
$followJs = <<<EOT

function cambioSeguimiento(event){
    var libro_id = event.target.parentNode.parentNode.attributes['data-seguimiento'].nodeValue;
    var estado_id = event.target.parentNode.attributes['data-id'].nodeValue;
    $.ajax({
        url: '$url1',
        data: { libro_id: libro_id,
                usuario_id: '$usuarioId',
                estado_id: estado_id},
        success: function(data){
        }
    });
}

$(document).ready(function(){
    $('.dropdown$id > li ').click(cambioSeguimiento);
});

EOT;
$this->registerJs($followJs);
?>

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
                      <button style="margin-left:20px" class="btn btn-default dropdown-toggle" id="dropdownMenu<?=$id?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        ...
                      </button>
                      <ul class="dropdown-menu dropdown<?=$id?>" aria-labelledby="dropdownMenu<?=$id?>" data-seguimiento="<?= $id ?>">
                        <li data-id='1'><a>Leído</a></li>
                        <li data-id='2'><a>Leyendo</a></li>
                        <li data-id='3'><a>Me gustaría leerlo</a></li>
                        <li role="separator" class="divider"></li>
                        <li data-id='4'><a>Limpiar seguimiento</a></li>
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
