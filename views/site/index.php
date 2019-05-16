<?php

/* @var $this yii\web\View */
use yii\helpers\Html;


$this->title = 'Libraryii';
?>
<style>
.portada{
    margin-top: -20px;
    margin-bottom: -20px;
    width: 190%%;
    margin-left: -34%;
    opacity: 0.2;
}
</style>

    <?= Html::img(Yii::getAlias('@uploads').'/libreria.jpg', ['class' => 'portada']); ?>
