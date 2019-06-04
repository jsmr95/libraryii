<?php

use app\models\Libros;
use app\models\Estados;

use kartik\select2\Select2;

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

    <?php if(Yii::$app->user->isGuest) {
        return Yii::$app->response->redirect(['site/index']);
    } ?>


    <div class="row">
        <h1><?= Html::encode($this->title) ?></h1>
        
        <div class="col-md-6 col-xs-6">
            <div class="estados-form">

                <?php $form = ActiveForm::begin([
                    'action' => ['estados/create'],
                    'options' =>   ['method' => 'post'],
                ]); ?>
                <?php
                $model = new Estados();
                $model->usuario_id = Yii::$app->user->id;
                $libros = Libros::find()->all();
                $dataLibros = [];
                foreach ($libros as $libro) {
                    array_push($dataLibros,$libro->titulo);
                }
                // var_dump($libros); die();
                ?>

                <?= $form->field($model, 'usuario_id')->textInput()->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'estado')->textarea(['maxlength' => true])->label('Que quieres postear?') ?>

                <?= $form->field($model, 'created_at')->textInput()->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'libro_id')->widget(Select2::className(), [
                    'data' => $dataLibros,
                    'options' => ['placeholder' => 'Selecciona un libro si lo deseas, para hacer referencia a él'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]); ?>

                <div class="form-group">
                    <?= Html::submitButton('Postear', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
        <div class="col-md-6 col-xs-6">

            <?php echo $this->render('_search', ['model' => $searchModel, 'sort' =>$dataProvider->sort]); ?>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_estados',
        'summary' => '',
    ]); ?>


</div>
