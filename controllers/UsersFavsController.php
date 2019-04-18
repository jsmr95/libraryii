<?php

namespace app\controllers;

use app\models\UsersFavs;
use app\models\UsersFavsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UsersFavsController implements the CRUD actions for UsersFavs model.
 */
class UsersFavsController extends Controller
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
     * Lists all UsersFavs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersFavsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsersFavs model.
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
     * Creación de un seguimiento, un usuario sigue a otro.
     * @return mixed
     * @param mixed $usuario_fav
     */
    public function actionCreate($usuario_fav)
    {
        //Modificar
        $id = Yii::$app->user->id;
        $model = UsersFavs::find()
            ->where([
            'usuario_id' => $id,
            'usuario_fav' => $usuario_fav,
        ])->one();

        if ($model) {
            if (!$model->delete()) {
                Yii::$app->session->setFlash('error', 'Ocurrió algún error!');
            } else {
                return '-empty';
            }
        } else {
            $nuevo = new UsersFavs([
                'usuario_id' => $id,
                'usuario_fav' => $usuario_fav,
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
     * Updates an existing UsersFavs model.
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
     * Deletes an existing UsersFavs model.
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
     * Finds the UsersFavs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return UsersFavs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsersFavs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
