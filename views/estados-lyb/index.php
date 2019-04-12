<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EstadosLybSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estados Lybs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-lyb-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Estados Lyb', ['create'], ['class' => 'btn btn-success']) ?>
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
