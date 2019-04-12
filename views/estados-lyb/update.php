<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EstadosLyb */

$this->title = 'Update Estados Lyb: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Estados Lybs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estados-lyb-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
