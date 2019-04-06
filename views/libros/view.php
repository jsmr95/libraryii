<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Libros */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="libros-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <!-- Muestro estas opciones solo para el admin -->
    <?php
        if (!Yii::$app->user->isGuest){
        if (Yii::$app->user->identity->login === 'admin'){
    ?>
    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php } } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'titulo',
            'isbn',
            'anyo',
            'sinopsis',
            'url_compra:url',
            'autor_id',
            'genero_id',
        ],
    ]) ?>
    <!-- Crear una vista mejorada -->

</div>
