<?php

namespace app\controllers;

use app\models\AutoresFavs;
use app\models\AutoresFavsSearch;
use app\models\Libros;
use app\models\LibrosFavs;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AutoresFavsController implements the CRUD actions for AutoresFavs model.
 */
class AutoresFavsController extends Controller
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
     * Lists all AutoresFavs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AutoresFavsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AutoresFavs model.
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
     * Creates a new AutoresFavs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @param mixed $autor_id
     */
    public function actionCreate($autor_id)
    {
        //Modificar
        $id = Yii::$app->user->id;
        $model = AutoresFavs::find()
            ->where([
            'usuario_id' => $id,
            'autor_id' => $autor_id,
        ])->one();

        if ($model) {
            if (!$model->delete()) {
                Yii::$app->session->setFlash('error', 'Ocurrió algún error!');
            } else {
                return '-empty';
            }
        } else {
            $nuevo = new AutoresFavs([
                'usuario_id' => $id,
                'autor_id' => $autor_id,
            ]);
            if (!$nuevo->save()) {
                Yii::$app->session->setFlash('error', 'Ocurrió algún error!');
            } else {
                $libros = Libros::find()->where(['autor_id' => $autor_id])->all();
                for ($i = 0; $i < count($libros); $i++) {
                    $libroFav = LibrosFavs::find()->where(['libro_id' => $libros[$i]->id, 'usuario_id' => $id])->one();
                    if ($libroFav) {
                        $libroFav->delete();
                    }
                }
                return '';
            }
            return '';
        }
    }

    /**
     * Updates an existing AutoresFavs model.
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
     * Deletes an existing AutoresFavs model.
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
     * Finds the AutoresFavs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return AutoresFavs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AutoresFavs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
