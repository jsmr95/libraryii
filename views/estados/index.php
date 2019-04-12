<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EstadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login === 'admin'){
    ?>
    <p>
        <?= Html::a('Crear estado', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php } ?>

    <?php echo $this->render('_search', ['model' => $searchModel, 'sort' =>$dataProvider->sort]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_estados',
    ]); ?>


</div>
