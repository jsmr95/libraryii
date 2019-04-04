<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property int $usuario_id
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
 * @property AutoresFavs[] $autoresFavs
 * @property Comentarios[] $comentarios
 * @property LibrosFavs[] $librosFavs
 * @property Posts[] $posts
 * @property UsersFavs[] $usersFavs
 * @property UsersFavs[] $usersFavs0
 * @property UsuariosId $usuario
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
            [['usuario_id', 'login', 'email', 'nombre', 'apellido', 'password'], 'required'],
            [['usuario_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['id', 'created_at', 'updated_at'], 'safe'],
            [['login', 'email', 'nombre', 'apellido', 'biografia', 'url_avatar', 'password', 'auth_key'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['login'], 'unique'],
            [['usuario_id'], 'unique'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usuario_id' => 'Usuario ID',
            'login' => 'Login',
            'email' => 'Email',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'biografia' => 'Biografia',
            'url_avatar' => 'Url Avatar',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoresFavs()
    {
        return $this->hasMany(AutoresFavs::className(), ['usuario_id' => 'usuario_id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::className(), ['usuario_id' => 'usuario_id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibrosFavs()
    {
        return $this->hasMany(LibrosFavs::className(), ['usuario_id' => 'usuario_id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::className(), ['usuario_id' => 'usuario_id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersFavs()
    {
        return $this->hasMany(UsersFavs::className(), ['usuario_id' => 'usuario_id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersFavs0()
    {
        return $this->hasMany(UsersFavs::className(), ['usuario_fav' => 'usuario_id'])->inverseOf('usuarioFav');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id'])->inverseOf('usuarios');
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
                goto salto;
            }
        } elseif ($this->scenario === self::SCENARIO_UPDATE) {
            if ($this->password === '') {
                $this->password = $this->getOldAttribute('password');
            } else {
                salto:
                $this->password = Yii::$app->security
                    ->generatePasswordHash($this->password);
            }
        }
    }
}
