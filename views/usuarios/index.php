<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosFavsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-index">
    <div class="row">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_usuarios',
            'summary' => '',
        ]); ?>
        </div>
    </div>
</div>
