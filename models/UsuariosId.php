<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios_id".
 *
 * @property int $id
 *
 * @property AutoresFavs[] $autoresFavs
 * @property Comentarios[] $comentarios
 * @property EstadoPersonal[] $estadoPersonals
 * @property Estados[] $estados
 * @property EstadosFavs[] $estadosFavs
 * @property EstadosLyb[] $estadosLybs
 * @property LibrosFavs[] $librosFavs
 * @property UsersFavs[] $usersFavs
 * @property UsersFavs[] $usersFavs0
 * @property Usuarios $usuarios
 */
class UsuariosId extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios_id';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoresFavs()
    {
        return $this->hasMany(AutoresFavs::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoPersonals()
    {
        return $this->hasMany(EstadoPersonal::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstados()
    {
        return $this->hasMany(Estados::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadosFavs()
    {
        return $this->hasMany(EstadosFavs::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadosLybs()
    {
        return $this->hasMany(EstadosLyb::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibrosFavs()
    {
        return $this->hasMany(LibrosFavs::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersFavs()
    {
        return $this->hasMany(UsersFavs::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersFavs0()
    {
        return $this->hasMany(UsersFavs::className(), ['usuario_fav' => 'id'])->inverseOf('usuarioFav');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id'])->inverseOf('id0');
    }
}
