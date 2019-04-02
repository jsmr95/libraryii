<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AutoresFavsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Autores Favs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="autores-favs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Autores Favs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'usuario_id',
            'autor_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
