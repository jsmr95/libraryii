<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\widgets\Pjax;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LibrosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Libros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libros-index" >
    <h1 ><?= Html::encode($this->title) ?>
        <?php
        if(!isset($ultimos)){
            echo Html::a('Ultimos lanzamientos',['libros/ultimos'], ['style' => 'float: right; font-size: 15px;']);
        } else {
            echo Html::a('Todos los libros',['libros/index'], ['style' => 'float: right; font-size: 15px;']);
        }
         ?>
    </h1>

    <?php
        if (!Yii::$app->user->isGuest){
        if (Yii::$app->user->identity->login === 'admin'){
    ?>
    <p>
        <?= Html::a('Introducir Libro', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php  } } ?>


    <?php echo $this->render('_search', ['model' => $searchModel, 'sort' => $dataProvider->sort]);
    ?>

    <?php Pjax::begin(); ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_libros',
        'summary' => '',
    ]);
    Pjax::end();
    ?>


</div>
