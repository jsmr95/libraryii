<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LibrosFavs */

$this->title = 'Create Libros Favs';
$this->params['breadcrumbs'][] = ['label' => 'Libros Favs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libros-favs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
