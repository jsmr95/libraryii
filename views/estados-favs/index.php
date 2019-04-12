<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EstadosFavsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estados Favs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-favs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Estados Favs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'usuario_id',
            'estado_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
