<?php

namespace app\controllers;

use app\models\Usuarios;
use app\models\UsuariosId;
use app\models\UsuariosIdSearch;
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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //genero un usuario_id para asociarle al usuario que voy a crear
            $idUsuario = new UsuariosId();
            $idUsuario->save();
            $model->id = $idUsuario->id;

            $model->save();
            $this->enviarEmail(
                $model,
                'mail',
                'Confirmación de usuario',
                'Se ha enviado un correo de confirmación, por favor, consulte su correo.',
                'Ha habido un error al mandar el correo de confirmación.'
            );
            return;
        }

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
     * @param mixed $vista
     * @param mixed $asunto
     * @param mixed $mensajeOk
     * @param mixed $mensajeError
     * @return [action] Realiza una accion
     */
    public function enviarEmail($model, $vista, $asunto, $mensajeOk, $mensajeError)
    {
        if (Yii::$app->mailer->compose($vista, [
            'model' => $model,
        ])
            ->setFrom('libraryiidaw@gmail.com')
            ->setTo($model->email)
            ->setSubject($asunto)
            ->send()) {
            Yii::$app->session->setFlash('success', $mensajeOk);
        } else {
            Yii::$app->session->setFlash('error', $mensajeError);
        }
        return $this->redirect(['site/index']);
    }

    /**
     * Accion para verificar un usuario.
     * @return [action] Redirecciona al site/index
     */
    public function actionVerificar()
    {
        //extract(Yii::$app->request->post('x_Usuarios'));
        //A jose se le manda por post x_Usuarios y a joni Usuarios.
        //Tenemos que extraerlo de diferente forma cada uno, no sabemos el motivo.
        //Esto de aqui abajo lo resuelve.
        $post = Yii::$app->request->post();
        $keys = preg_grep('/.*Usuarios.*/i', array_keys($post));
        extract(Yii::$app->request->post($keys[1]));
        $usuario = Usuarios::findByUserName($login);
        if (isset($usuario)) {
            if ($usuario->auth_key === $auth_key) {
                $usuario->auth_key = '';
                if ($usuario->save()) {
                    Yii::$app->session->setFlash('success', 'Se ha verificado su usuario CORRECTAMENTE, puedes iniciar sesión.');
                } else {
                    Yii::$app->session->setFlash('error', 'ERROR: No se ha verificado su usuario correctamente1.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'ERROR: No se ha verificado su usuario correctamente.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'ERROR: No se ha verificado.');
        }
        return $this->redirect(['site/index']);
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
