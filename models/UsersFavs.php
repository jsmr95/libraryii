<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_favs".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $usuario_fav
 *
 * @property UsuariosId $usuario
 * @property UsuariosId $usuarioFav
 */
class UsersFavs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_favs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'usuario_fav'], 'default', 'value' => null],
            [['usuario_id', 'usuario_fav'], 'integer'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['usuario_fav'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['usuario_fav' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'usuario_fav' => 'Usuario Fav',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id'])->inverseOf('usersFavs');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioFav()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_fav'])->inverseOf('usersFavs0');
    }
}
