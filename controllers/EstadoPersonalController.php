<?php

namespace app\controllers;

use app\models\EstadoPersonal;
use app\models\EstadoPersonalSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EstadoPersonal implements the CRUD actions for EstadoPersonal model.
 */
class EstadoPersonalController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EstadoPersonal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EstadoPersonalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EstadoPersonals model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EstadoPersonals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @param mixed $contenido
     * @param mixed $usuario_id
     */
    public function actionCreate($usuario_id, $contenido)
    {
        $model = EstadoPersonal::find()->where(['usuario_id' => $usuario_id])->one();

        if ($model) {
            if (!$model->delete()) {
                Yii::$app->session->setFlash('error', 'Ocurrió algún error!');
            }
        }
        $nuevo = new EstadoPersonal([
            'usuario_id' => $usuario_id,
            'contenido' => $contenido,
        ]);
        if (!$nuevo->save()) {
            Yii::$app->session->setFlash('error', 'Ocurrió algún error!');
        }
    }


    /**
     * Updates an existing EstadoPersonal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EstadoPersonal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EstadoPersonal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return EstadoPersonal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EstadoPersonal::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
