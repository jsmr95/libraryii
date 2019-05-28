<?php

namespace app\controllers;

use app\models\Usuarios;
use app\models\UsuariosId;
use app\models\UsuariosSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

require '../web/uploads3.php';

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
        $searchModel = new UsuariosSearch();
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
            if (!empty($_FILES)) {
                $model->url_avatar = $_FILES['Usuarios']['name']['url_avatar'];
            }

            $model->save();
            $this->enviarEmail(
                $model,
                'mail',
                'Confirmación de usuario',
                'Se ha enviado un correo de confirmación, por favor, consulte su correo.',
                'Ha habido un error al mandar el correo de confirmación.'
            );
            //Subo la imagen
            if (!empty($_FILES['Usuarios']['name']['url_avatar'])) {
                uploadImagen($model);
            }
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
        $model->scenario = 'update';

        //La acción de borrar la imagen que teniamos para subir otra (modificar),
        //la realizo en el beforesave()
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($_FILES['Usuarios']['name']['url_avatar'])) {
                uploadImagen($model);
                $model->url_avatar = $_FILES['Usuarios']['name']['url_avatar'];
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $model->password = '';
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
        $usuarioId = UsuariosId::findOne($id);
        $usuarioId->delete();

        return $this->redirect(['site/index']);
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
     * Accion para mandar el correo segun me pasen email o el login.
     * @return [action] Renderiza a una vista donde te dá la opcion de modificar la contraseña
     */
    public function actionRecuperarcontra()
    {
        if ($emailNombre = Yii::$app->request->post('emailNombre')) {
            $usuarioNombre = Usuarios::findByUsername($emailNombre);
            $usuarioEmail = Usuarios::findByEmail($emailNombre);

            if (isset($usuarioNombre) || isset($usuarioEmail)) {
                if (isset($usuarioNombre)) {
                    $this->enviarEmail(
                        $usuarioNombre,
                        'recuperarcontra',
                        'Recuperación de contraseña',
                        'Se ha enviado un correo para restablecer su contraseña ,porfavor, consulte su correo.',
                        'Ha ocurrido un error al mandar el correo.'
                        );
                } else {
                    $this->enviarEmail(
                        $usuarioEmail,
                        'recuperarcontra',
                        'Recuperación de contraseña',
                        'Se ha enviado un correo para restablecer su contraseña ,porfavor, consulte su correo.',
                        'Ha ocurrido un error al mandar el correo.'
                        );
                }
            } else {
                Yii::$app->session->setFlash('error', 'El usuario o email no son correctos.');
            }
        }
        return $this->render('recuperarcontra');
    }

    /**
     * Funcion para modificar la contraseña.
     * @return [type] [description]
     */
    public function actionModificarcontra()
    {
        $post = Yii::$app->request->post();
        $keys = preg_grep('/.*Usuarios.*/i', array_keys($post));
        extract(Yii::$app->request->post($keys[1]));
        $model = $this->findModel($id);
        $model->scenario = Usuarios::SCENARIO_UPDATE;


        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            //cambio la fecha de modificacion
            $model->updated_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Se ha modificado su contraseña correctamente.');

                return $this->redirect(['site/index']);
            }
        }

        $model->password = $model->password_repeat = '';


        return $this->render('modificarcontra', [
            'model' => $model,
        ]);
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

    /**
     * Accion para que el admin pueda banear a los usuarios.
     * @param  int $id id del usuario a banear
     */
    public function actionBanear($id)
    {
        $usuario = $this->findModel($id);
        $usuario->banned_at = empty($usuario->banned_at) ?
            (new \DateTime())
                ->add(new \DateInterval('P2D'))
                ->format('Y-m-d H:i:s') : null;
        $usuario->save();

        return $this->redirect(['usuarios/index']);
    }
}
