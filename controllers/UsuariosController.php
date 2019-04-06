<?php

namespace app\controllers;

use app\models\Usuarios;
use app\models\UsuariosId;
use app\models\UsuariosIdSearch;
use http\Url;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
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
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'only' => ['create'],
            //     'rules' => [
            //         'allow' => true,
            //         'actions' => ['create'],
            //         'roles' => ['?'],
            //     ],
            // ],
        ];
    }

    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosIdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuarios model.
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
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_CREATE]);
        //genero un usuario_id para asociarle al usuario que voy a crear

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $idUsuario = new UsuariosId();
            $idUsuario->save();
            $model->id = $idUsuario->id;

            $model->save();
            return $this->redirect('index');
            // $this->enviarEmail($model);
        }

        $model->password = '';
        $model->password_repeat = '';
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->usuario_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuarios model.
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
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Enviar un email de verificacion al usuario.
     * @param  Usuarios $model Usuario receptor
     * @return [action] Realiza una accion
     */
    public function enviarEmail($model)
    {
        $url = Url::to([
            'usuarios/verificar',
            'id' => $model->id,
            'auth_key' => $model->auth_key,
        ], true);

        if (Yii::$app->mailer->compose()
            ->setFrom('josemaria.gallego@iesdonana.org')
            ->setTo($model->email)
            ->setSubject('Libraryii - Correo de confirmación')
            ->setTextBody("Verique su cuenta clicando en el siguiente enlace: $url")
            ->send()
        ) {
            Yii::$app->session->setFlash('success', 'Se ha enviado un correo de confirmación a su email, por favor verifiquelo.');
        } else {
            Yii::$app->session->setFlash('error', 'Se ha producido un error al mandar el correo de confirmación.');
        }
        return $this->redirect(['index']);
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
