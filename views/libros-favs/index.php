<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LibrosFavsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Libros Favs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libros-favs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Libros Favs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'usuario_id',
            'libro_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
