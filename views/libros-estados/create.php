<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LibrosEstados */

$this->title = 'Create Libros Estados';
$this->params['breadcrumbs'][] = ['label' => 'Libros Estados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libros-estados-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
