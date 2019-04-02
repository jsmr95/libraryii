<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AutoresFavs */

$this->title = 'Create Autores Favs';
$this->params['breadcrumbs'][] = ['label' => 'Autores Favs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="autores-favs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
