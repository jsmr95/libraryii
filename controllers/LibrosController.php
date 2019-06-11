<?php

namespace app\controllers;

use app\models\Autores;
use app\models\AutoresFavs;
use app\models\Comentarios;
use app\models\Generos;
use app\models\Libros;
use app\models\LibrosFavs;
use app\models\LibrosSearch;
use app\models\Votos;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

require '../web/uploads3.php';

/**
 * LibrosController implements the CRUD actions for Libros model.
 */
class LibrosController extends Controller
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
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->login === 'admin';
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Libros models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LibrosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 5];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Libros model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $comentarios = Comentarios::find()
           ->where([
               'comentario_id' => null,
               'libro_id' => $id,
           ])
           ->orderBy(['created_at' => SORT_DESC])
           ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'comentarios' => $comentarios,
        ]);
    }

    /**
     * Creates a new Libros model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Libros();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!empty($_FILES)) {
                $model->imagen = $_FILES['Libros']['name']['imagen'];
            }
            $model->save();
            if (!empty($_FILES['Libros']['name']['imagen'])) {
                uploadImagenLibro($model);
            }
            return;
        }


        return $this->render('create', [
            'model' => $model,
            'listaGeneros' => $this->listaGeneros(),
            'listaAutores' => $this->listaAutores(),
        ]);
    }

    /**
     * Updates an existing Libros model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($_FILES['Libros']['name']['imagen'])) {
                uploadImagenLibro($model);
                $model->imagen = $_FILES['Libros']['name']['imagen'];
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'listaGeneros' => $this->listaGeneros(),
            'listaAutores' => $this->listaAutores(),
        ]);
    }

    /**
     * Deletes an existing Libros model.
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
     * Finds the Libros model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Libros the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Libros::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Lista de Generos para mostrarlos a la hora de crear un libro o modificarlo.
     * @return array Array de generos
     */
    private function listaGeneros()
    {
        return array_merge([''], Generos::find()
            ->select('genero')
            ->indexBy('id')
            ->column());
    }

    /**
     * Lista de Autores para mostrarlos a la hora de crear un libro o modificarlo.
     * @return array Array de autores
     */
    private function listaAutores()
    {
        return array_merge([''], Autores::find()
            ->select('nombre')
            ->indexBy('id')
            ->column());
    }

    /**
     * Funcion para calcular la media de los votos de un libro.
     * @return int media de votos de un libro
     * @param mixed $libro_id
     */
    public function actionCalculamediavotos($libro_id)
    {
        if (($model = Libros::findOne($libro_id)) !== null) {
            $filas = Votos::find()->where(['libro_id' => $libro_id])->all();
            if (count($filas)) {
                $sumaTotal = 0;
                foreach ($filas as $fila) {
                    $sumaTotal += $fila->voto;
                }
                $res = $sumaTotal / count($filas);
                $model->mediaVotos = $res;
                // var_dump($model->mediaVotos);
                // die();
                return $res;
            }
            return 0;
        }
        return 0;
    }

    /**
     * Lista de los libros ordenados desde los mas nuevos a mas viejos, simulando
     * los ultimos lanzamientos.
     * @return mixed
     */
    public function actionUltimos()
    {
        $searchModel = new LibrosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 5];
        $dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ultimos' => 'ultimos',
        ]);
    }

    /**
     * Función para consultar a los que le gusta ese libro.
     * @param mixed $libro_id id del libro
     * @return int numero de seguidores que tiene el libro
     */
    public function actionConsultaseguidores($libro_id)
    {
        $libro = Libros::find($libro_id)->one();
        $seguidores1 = LibrosFavs::find()->where(['libro_id' => $libro_id])->all();
        $seguidores2 = AutoresFavs::find()->where(['autor_id' => $libro->autor->id])->all();

        return count($seguidores1) + count($seguidores2);
    }
}
