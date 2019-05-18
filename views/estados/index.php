<?php

use app\models\Estados;

use yii\helpers\Html;
use yii\grid\GridView;

use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EstadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Social';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estados-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel, 'sort' =>$dataProvider->sort]); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="estados-form">

                <?php $form = ActiveForm::begin([
                    'action' => ['estados/create'],
                    'options' =>   ['method' => 'post'],
                    ]); ?>
                <?php
                    $model = new Estados();
                    $model->usuario_id = Yii::$app->user->id;
                ?>

                <?= $form->field($model, 'usuario_id')->textInput()->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'estado')->textarea(['maxlength' => true])->label('Que quieres postear?') ?>

                <?= $form->field($model, 'created_at')->textInput()->hiddenInput()->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Postear', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_estados',
        'summary' => '',
    ]); ?>


</div>
