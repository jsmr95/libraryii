<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersFavsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users Favs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-favs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Users Favs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'usuario_id',
            'usuario_fav',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
