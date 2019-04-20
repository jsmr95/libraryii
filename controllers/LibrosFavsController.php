<?php

namespace app\controllers;

use app\models\LibrosFavs;
use app\models\LibrosFavsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * LibrosFavsController implements the CRUD actions for LibrosFavs model.
 */
class LibrosFavsController extends Controller
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
     * Lists all LibrosFavs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LibrosFavsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LibrosFavs model.
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
     * Creates a new LibrosFavs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param mixed $libro_id
     * @return mixed
     */
    public function actionCreate($libro_id)
    {
        $id = Yii::$app->user->id;
        $model = LibrosFavs::find()
            ->where([
            'usuario_id' => $id,
            'libro_id' => $libro_id,
        ])->one();

        if ($model) {
            if (!$model->delete()) {
                Yii::$app->session->setFlash('error', 'Ocurrió algún error!');
            } else {
                return '-empty';
            }
        } else {
            $nuevo = new LibrosFavs([
                'usuario_id' => $id,
                'libro_id' => $libro_id,
            ]);
            if (!$nuevo->save()) {
                Yii::$app->session->setFlash('error', 'Ocurrió algún error!');
            } else {
                return '';
            }
            return '';
        }
    }

    /**
     * Updates an existing LibrosFavs model.
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
     * Deletes an existing LibrosFavs model.
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
     * Finds the LibrosFavs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return LibrosFavs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LibrosFavs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
