<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EstadosLyb */

$this->title = 'Create Estados Lyb';
$this->params['breadcrumbs'][] = ['label' => 'Estados Lybs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-lyb-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
