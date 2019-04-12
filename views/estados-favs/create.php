<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EstadosFavs */

$this->title = 'Create Estados Favs';
$this->params['breadcrumbs'][] = ['label' => 'Estados Favs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-favs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
