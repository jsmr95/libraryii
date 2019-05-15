<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LibrosEstados */

$this->title = 'Update Libros Estados: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Libros Estados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="libros-estados-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
