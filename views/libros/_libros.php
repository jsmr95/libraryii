<?php
use app\models\Usuarios;
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
    background-color: #ffe6cc;
    position: relative;
    padding: 5px 10px 5px 30px;
    border-radius: 6px;
    -webkit-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    -moz-box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
    box-shadow: 7px 7px 45px -23px rgba(0,0,0,0.75);
}
.libro-texto {
    padding-top: 5px;
    font-family: cursive;
}
img.libros {
    width: 170px !important;
    height: 200px !important;
    padding-top: 5px;
    padding-bottom: 5px;
    margin: 10px;
    border-radius: 12px;
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
.glyphicon-star, .glyphicon-star-empty{
    color: rgb(247, 185, 43);
    font-size: 30px;
    height: 35px;
}
.dropdown {
    float: right;
    margin-bottom: 30px;
    padding: 15px;
}
button[data-libro] {
    padding: 0;
    border: none;
    background: none;
}
</style>

<?php
$url1 = Url::to(['seguimientos/create']);
$url2 = Url::to(['libros-favs/create']);

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

function seguir(event){
    var libro_id = event.target.parentNode.attributes['data-libro'].nodeValue;
    $.ajax({
        url: '$url2',
        data: { libro_id: libro_id},
        success: function(data){
            if (data == '') {
                $(`#estrella`+libro_id).removeClass('glyphicon-star-empty');
                $(`#estrella`+libro_id).addClass('glyphicon-star');
            } else {
                $(`#estrella`+libro_id).removeClass('glyphicon-star');
                $(`#estrella`+libro_id).addClass('glyphicon-star-empty');
            }
        }
    });
}

$(document).ready(function(){
    $('.follow$id').click(seguir);
    $('.dropdown$id > li ').click(cambioSeguimiento);
});

EOT;
$this->registerJs($followJs);
?>

<div class="row libro" itemscope itemtype="http://schema.org/Book">
    <!-- Fila para cada libro-->
    <div class="col-md-12 col-xs-12 col-lg-12 libro-cuerpo " >
        <!-- Columna completa de cada libro-->
        <div class="col-md-3 col-xs-3 col-lg-3">
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
        <div class="col-md-9 col-xs-9 col-lg-9 libro-cabecera ">
            <div class="row">
                <div class="col-md-9 col-xs-9 col-lg-9">
                    <h2 itemprop="name">
                        <?= Html::a($model->titulo, [
                        'libros/view',
                        'id' => $model->id
                        ]) ?>
                        <!-- Botón para seguimiento -->
                        <?php
                        $corazon = '';
                        $disabled = false;
                        if (!Yii::$app->user->isGuest):
                        $usuario = Usuarios::findOne(Yii::$app->user->id);
                        $corazon = $usuario->consultaLibroSeguido($usuario->id, $model->id);

                        if ($corazon == 'autor') {
                            $corazon = '';
                            $disabled = true;
                        }
                        ?>
                        <!-- FAVORITO -->
                        <button class="follow<?=$model->id?>" data-libro="<?= $model->id ?>"
                            <?php if($disabled){ echo "disabled title='No puedes desmarcarlo, te gusta el autor'";}
                            else {
                                echo "title='Marcar como favorito'";
                            }  ?>>
                            <span id="estrella<?=$model->id?>" class='glyphicon glyphicon-star<?=$corazon?>' aria-hidden='true'></span>
                        </button>
                    </h2>
                </div>
                <div class="col-md-3 col-xs-3 col-lg-3">
                    <?php
                    $seguimientoStr = '...';
                    $seguimiento = Seguimientos::find()
                    ->where(['usuario_id' => $usuarioId, 'libro_id' => $id])
                    ->one();
                    if ($seguimiento) {
                        if ($seguimiento->estado_id == 1) {
                            $seguimientoStr = "Leído <span class='glyphicon glyphicon-chevron-down'></span>";
                        } else if ($seguimiento->estado_id == 2) {
                            $seguimientoStr = "Leyendo  <span class='glyphicon glyphicon-chevron-down'></span>";
                        } else {
                            $seguimientoStr = "Me gustaría leerlo  <span class='glyphicon glyphicon-chevron-down'></span>";
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
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-4">
                    <ul>
                        <li itemprop="author">Autor: <?= Html::a($model->autor->nombre, ['autores/view', 'id' => $model->autor->id]) ?></li>
                        <li itemprop="copyrightYear">Año: <?= $model->anyo ?></li>
                        <li itemprop="genre">Género: <?= $model->genero->genero ?></li>
                        <li itemprop="isbn">ISBN: <?= $model->isbn ?></li>
                        <li title="Enlace a compra"> <?= Html::a('Compra', $model->url_compra) ?>
                        </li>
                    </ul>
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
                <div class="col-lg-8 col-md-8 col-xs-8">
                    <div itemprop="description">
                        <!-- Columna de 5 para la sinopsis-->
                        <?= $model->sinopsis  ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
