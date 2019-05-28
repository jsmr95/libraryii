<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

//require '../web/uploads3.php';


/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $login
 * @property string $email
 * @property string $nombre
 * @property string $apellido
 * @property string $biografia
 * @property string $url_avatar
 * @property string $password
 * @property string $auth_key
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UsuariosId $id0
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * Escenario donde un usuario se registra.
     * @var string
     */
    const SCENARIO_CREATE = 'create';

    /**
     * Escenario donde un usuario se modifica.
     * @var string
     */
    const SCENARIO_UPDATE = 'update';

    /**
     * Contraseña para verificar que el usuario no la ha escrito mal.
     * @var string
     */
    public $password_repeat;

    /**
     * Variable para saber si un usuario tiene algun baneo o no.
     * @var string
     */
    public $_baneado;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'email', 'nombre', 'apellido', 'password', 'password_repeat'], 'required', 'on' => [self::SCENARIO_CREATE]],
            [['password'], 'compare', 'on' => [self::SCENARIO_CREATE]],
            [['email', 'login'], 'unique', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password',
                'skipOnEmpty' => false, 'on' => [self::SCENARIO_UPDATE], ],
            [['email'], 'email', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['id', 'created_at', 'updated_at'], 'safe'],
            [['login', 'email', 'nombre', 'apellido', 'biografia', 'url_avatar', 'password', 'auth_key'], 'string', 'max' => 255],
            [['auth_key'], 'default', 'value' => function () {
                return $this->auth_key = Yii::$app->security->generateRandomString();
            }, 'on' => [self::SCENARIO_CREATE]],
            [['created_at'], 'default', 'value' => function () {
                return date('Y-m-d h:i:s');
            }, 'on' => [self::SCENARIO_CREATE]],
            [['updated_at'], 'default', 'value' => function () {
                return date('Y-m-d H:i:s');
            }, 'on' => [self::SCENARIO_UPDATE]],
        ];
    }

    /**
     * Función para añadir un atributo al conjunto de atributos.
     * @return array Conjunto de atributos mergeados.
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['password_repeat']);
    }

    /**
     * Función para cambiar los nombres de las columnas, por un formato más social.
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'email' => 'Email',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'biografia' => 'Descripción',
            'url_avatar' => 'Avatar',
            'password' => 'Contraseña',
            'password_repeat' => 'Repita contraseña',
            'auth_key' => 'Auth Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Busca Usuarios por el login.
     *
     * @param mixed $login login ha buscar
     * @return static|null
     */
    public static function findByUsername($login)
    {
        return static::findOne(['login' => $login]);
    }

    /**
     * Busca Usuarios por el email.
     *
     * @param mixed $email email ha buscar
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Encuentra una identidad dado un ID.
     *
     * @param  string|int $id El id para buscar
     * @return IdentityInterface|null el objecto cuyo ID corresponde
     * con el dado.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Encuentra una identidad dado un token.
     *
     * @param  string $token El token para buscar
     * @param  null|mixed $type
     * @return IdentityInterface|null el objecto cuyo token corresponde
     * con el dado.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
    }

    /**
     * Valida la contraseña.
     *
     * @param string $password contraseña a validar
     * @return bool true si es correcta, false si no.
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Funcion para consultar si el usuario logueado, sigue o no, al usuario
     * que está consultando.
     * @param  int $miId id del usuario logueado
     * @param  int $seguidorId id del usuario al que visita
     * @return string res cadena que hará mostrar un corazón lleno (lo sigue)
     * o un corazon vacío (no lo sigue).
     */
    public function consultaSeguidor($miId, $seguidorId)
    {
        $fila = UsersFavs::find()->where(['usuario_id' => $miId])
            ->andWhere(['usuario_fav' => $seguidorId])->one();
        if ($fila) {
            return '';
        }
        return '-empty';
    }

    /**
     * Funcion para consultar si el usuario logueado, tiene o no, al libro
     * que está consultando en libros favoritos.
     * @param  int $miId id del usuario logueado
     * @param  int $libroId id del libro al que visita
     * @return string res cadena que hará mostrar una estrella llena (lo sigue)
     * o una estrella vacía (no lo sigue).
     */
    public function consultaLibroSeguido($miId, $libroId)
    {
        $fila = LibrosFavs::find()->where(['usuario_id' => $miId])
            ->andWhere(['libro_id' => $libroId])->one();
        if ($fila) {
            return '';
        }
        return '-empty';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'id'])->inverseOf('usuarios');
    }

    /**
     * Función para obtener el baneo.
     * @return string fecha si la hubiese hasta cuando está baneado.
     */
    public function getBaneado()
    {
        return $this->_baneado;
    }

    /**
     * Funcion afterFind para cambiar la variable baneado.
     */
    public function afterFind()
    {
        $this->_baneado = !empty($this->banned_at);
    }

    /**
     * Funcion que es llamada antes de insertar o actualizar un registro.
     * @param  bool $insert true->insert, false->update
     * @return bool true->inserccion o modificación llevada a cabo, false-> cancelado
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert) {
            if ($this->scenario === self::SCENARIO_CREATE) {
                $this->password = Yii::$app->security
                    ->generatePasswordHash($this->password);
            }
        } elseif ($this->scenario === self::SCENARIO_UPDATE) {
            if ($this->password === '') {
                $this->password = $this->getOldAttribute('password');
            } else {
                $this->password = Yii::$app->security
                    ->generatePasswordHash($this->password);
            }
            if ($this->url_avatar === '') {
                $this->url_avatar = $this->getOldAttribute('url_avatar');
            }
            $this->updated_at = date('Y-m-d H:i:s');
        }
        return true;
    }
}
