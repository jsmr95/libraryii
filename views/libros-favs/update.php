<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LibrosFavs */

$this->title = 'Update Libros Favs: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Libros Favs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="libros-favs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
