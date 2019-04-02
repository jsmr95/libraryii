<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AutoresFavs */

$this->title = 'Update Autores Favs: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Autores Favs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="autores-favs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
