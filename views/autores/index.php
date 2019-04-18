<?php

use yii\data\Pagination;

use yii\helpers\Html;
use yii\grid\GridView;

use yii\widgets\ListView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AutoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Autores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="autores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->login === 'admin'){
    ?>
    <p>
        <?= Html::a('Introducir Autor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php } ?>

    <?php echo $this->render('_search', ['model' => $searchModel, 'sort' => $dataProvider->sort]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_autores',
    ]); ?>


</div>
