<?php

namespace app\controllers;

use app\models\EstadosLyb;
use app\models\EstadosLybSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EstadosLybController implements the CRUD actions for EstadosLyb model.
 */
class EstadosLybController extends Controller
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
     * Lists all EstadosLyb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EstadosLybSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EstadosLyb model.
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
     * Creates a new EstadosLyb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @param mixed $usuario_id
     * @param mixed $estado_id
     */
    public function actionCreate($usuario_id, $estado_id)
    {
        $model = EstadosLyb::find()
            ->where([
            'usuario_id' => $usuario_id,
            'estado_id' => $estado_id,
        ])->one();

        if ($model) {
            if (!$model->delete()) {
                Yii::$app->session->setFlash('error', 'Ocurrió algún error!');
            } else {
                return 0;
            }
        } else {
            $nuevo = new EstadosLyb([
                'usuario_id' => $usuario_id,
                'estado_id' => $estado_id,
            ]);
            if (!$nuevo->save()) {
                Yii::$app->session->setFlash('error', 'Ocurrió algún error!');
            } else {
                return $estado_id;
            }
        }
    }

    /**
     * Updates an existing EstadosLyb model.
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
     * Deletes an existing EstadosLyb model.
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
     * Finds the EstadosLyb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return EstadosLyb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EstadosLyb::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
