<?php
use app\models\Seguimientos;

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
.dropdown-menu > li {
    cursor:pointer;
}
.share-buttons img {
width: 35px;
padding: 5px;
border: 0;
box-shadow: 0;
display: inline;
margin-top: 10px;
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
            $(`#dropdownMenu` + libro_id)[0].innerHTML = data;
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
    <div class="col-md-12 col-xs-12 libro-cuerpo " itemscope itemtype="http://schema.org/Book">
        <!-- Columna completa de cada libro-->
        <div class="col-md-3 col-xs-3">
            <!-- Columna de 3 para la imagen del libro-->
            <center>
                <p itemprop="image">
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
        <div class="col-md-4 col-xs-4 libro-cabecera ">
            <!-- Columna de 4 para la info de cada libro -->
            <p itemprop="name">
                <h2>
                    <?= Html::a($model->titulo, [
                    'libros/view',
                    'id' => $model->id
                    ]) ?>
                    <!-- Botón para seguimiento -->
                    <?php if (!Yii::$app->user->isGuest):
                    $seguimientoStr = '...';
                    $seguimiento = Seguimientos::find()
                    ->where(['usuario_id' => $usuarioId, 'libro_id' => $id])
                    ->one();
                    if ($seguimiento) {
                        if ($seguimiento->estado_id == 1) {
                            $seguimientoStr = 'Leído';
                        } else if ($seguimiento->estado_id == 2) {
                            $seguimientoStr = 'Leyendo';
                        } else {
                            $seguimientoStr = 'Me gustaría leerlo';
                        }
                    }
                    ?>

                    <span class="dropdown" title="Seguimiento">
                      <button style="margin-left:20px" class="btn btn-default dropdown-toggle" id="dropdownMenu<?=$id?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?= $seguimientoStr ?>
                      </button>
                      <ul class="dropdown-menu dropdown<?=$id?>" aria-labelledby="dropdownMenu<?=$id?>" data-seguimiento="<?= $id ?>">
                        <li data-id='1'><a>Leído</a></li>
                        <li data-id='2'><a>Leyendo</a></li>
                        <li data-id='3'><a>Me gustaría leerlo</a></li>
                        <li role="separator" class="divider"></li>
                        <li data-id='4'><a>Limpiar seguimiento</a></li>
                      </ul>
                    </span>
                    <?php endif; ?>
                </h2>

                <ul>
                    <li itemprop="author">Autor: <?= Html::a($model->autor->nombre, ['autores/view', 'id' => $model->autor->id]) ?></li>
                    <li itemprop="copyrightYear">Año: <?= $model->anyo ?></li>
                    <li itemprop="genre">Género: <?= $model->genero->genero ?></li>
                    <li itemprop="isbn">ISBN: <?= $model->isbn ?></li>
                    <li title="Enlace a compra"> <?= Html::a('Compra', $model->url_compra) ?>
                    </li>
                </ul>
            </p>
            <div class="share-buttons">
                <!-- Facebook -->
                <a href="http://www.facebook.com/sharer.php?u=https://libraryii.herokuapp.com/index.php?r=libros%2Findex" target="_blank" title="Compartir en Facebook">
                    <img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" />
                </a>

                <!-- Twitter -->
                <a href="https://twitter.com/share?url=https://libraryii.herokuapp.com/index.php?r=libros%2Findex" target="_blank" title="Compartir en Twitter">
                    <img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" />
                </a>

            </div>
        </div>
        <div class="col-md-5 col-xs-5 libro-texto " itemprop="description">
            <!-- Columna de 5 para la sinopsis-->
            <?= $model->sinopsis  ?>
        </div>
    </div>

</div>
