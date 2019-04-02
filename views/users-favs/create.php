<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsersFavs */

$this->title = 'Create Users Favs';
$this->params['breadcrumbs'][] = ['label' => 'Users Favs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-favs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
