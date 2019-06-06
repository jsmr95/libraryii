<style media="screen">
    #postear {
        border: 1px solid;
        border-radius: 15px;
        padding:20px;
    }
</style>
<?php

use app\models\Libros;
use app\models\Estados;

use kartik\select2\Select2;

use yii\helpers\Html;
use yii\grid\GridView;

use yii\widgets\Pjax;
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
        <div class="col-md-12 col-xs-12">
            <?php echo $this->render('_search', ['model' => $searchModel, 'sort' =>$dataProvider->sort]); ?>
        </div>
    </div>
    <br>
    <div class="row" id="postear" >
        <div class="row">
            <!-- <h1><?php //echo Html::encode($this->title) ?></h1> -->
            <?php $form = ActiveForm::begin([
                'action' => ['estados/create'],
                'options' =>   ['method' => 'post'],
            ]); ?>

            <div class="estados-form" >
                <div class="col-md-6 col-xs-6">

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
                </div>
                <div class="col-md-6 col-xs-6">
                    <?= $form->field($model, 'libro_id')->widget(Select2::className(), [
                        'data' => $dataLibros,
                        'options' => ['placeholder' => 'Selecciona un libro si lo deseas, para hacer referencia a él'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <center>
                <div class="form-group">
                    <?= Html::submitButton('Postear', ['class' => 'btn btn-success']) ?>
                </div>
            </center>
        </div>
    </div>
    <?php ActiveForm::end();
    Pjax::begin();
    // $dataProvider->pagination = ['pageSize' => 5];
    ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_estados',
        'summary' => '',
    ]);
    Pjax::end();
    ?>


</div>
