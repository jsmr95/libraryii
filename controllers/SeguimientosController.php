<?php

namespace app\controllers;

use app\models\Seguimientos;
use app\models\SeguimientosSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SeguimientosController implements the CRUD actions for Seguimientos model.
 */
class SeguimientosController extends Controller
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
     * Lists all Seguimientos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeguimientosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Seguimientos model.
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
     * Creamos un seguimiento a un libro determinado.
     * @param int $libro_id id del libro
     * @param int $usuario_id id del usuario
     * @param int $estado_id id del estado
     * @return mixed
     */
    public function actionCreate($libro_id, $usuario_id, $estado_id)
    {
        $model = Seguimientos::find()
            ->where([
            'usuario_id' => $usuario_id,
            'libro_id' => $libro_id,
        ])->one();

        $seguimientoStr = '...';
        if ($model) {
            if (!$model->delete()) {
                Yii::$app->session->setFlash('error', 'Ocurrió algún error!');
            } else {
                if ($estado_id != 4) {
                    $nuevo = new Seguimientos([
                        'usuario_id' => $usuario_id,
                        'libro_id' => $libro_id,
                        'estado_id' => $estado_id,
                    ]);
                    if (!$nuevo->save()) {
                        Yii::$app->session->setFlash('error', 'Ocurrió algún error!');
                    } else {
                        $seguimiento = Seguimientos::find()
                        ->where(['usuario_id' => $usuario_id, 'libro_id' => $libro_id])
                        ->one();
                        if ($seguimiento) {
                            if ($seguimiento->estado_id == 1) {
                                return $seguimientoStr = 'Leído';
                            } elseif ($seguimiento->estado_id == 2) {
                                return $seguimientoStr = 'Leyendo';
                            }
                            return $seguimientoStr = 'Me gustaría leerlo';
                        }
                    }
                } else {
                    return $seguimientoStr;
                }
            }
        } else {
            $nuevo = new Seguimientos([
                'usuario_id' => $usuario_id,
                'libro_id' => $libro_id,
                'estado_id' => $estado_id,
            ]);
            if (!$nuevo->save()) {
                Yii::$app->session->setFlash('error', 'Ocurrió algún error!');
            } else {
                $seguimiento = Seguimientos::find()
                ->where(['usuario_id' => $usuario_id, 'libro_id' => $libro_id])
                ->one();
                if ($seguimiento) {
                    if ($seguimiento->estado_id == 1) {
                        return $seguimientoStr = 'Leído';
                    } elseif ($seguimiento->estado_id == 2) {
                        return $seguimientoStr = 'Leyendo';
                    }
                    return $seguimientoStr = 'Me gustaría leerlo';
                }
            }
        }
    }

    /**
     * Updates an existing Seguimientos model.
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
     * Deletes an existing Seguimientos model.
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
     * Finds the Seguimientos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Seguimientos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seguimientos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
