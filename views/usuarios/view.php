<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Ver Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Social', 'url' => ['estados/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (!Yii::$app->user->isGuest){
        if (Yii::$app->user->identity->login === $model->login){
            ?>
    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar cuenta', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estás seguro que desea eliminar su cuenta? Se eliminará TODO su contenido registrado!',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php } }  ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'login',
            'email:email',
            'nombre',
            'apellido',
            'biografia',
            'url_avatar:url',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
