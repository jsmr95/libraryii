<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seguimientos".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $libro_id
 * @property int $estado_id
 *
 * @property Libros $libro
 * @property LibrosEstados $estado
 * @property UsuariosId $usuario
 */
class Seguimientos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguimientos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'libro_id', 'estado_id'], 'default', 'value' => null],
            [['usuario_id', 'libro_id', 'estado_id'], 'integer'],
            [['libro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Libros::className(), 'targetAttribute' => ['libro_id' => 'id']],
            [['estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => LibrosEstados::className(), 'targetAttribute' => ['estado_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['usuario_id' => 'id']],
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
            'libro_id' => 'Libro ID',
            'estado_id' => 'Estado ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibro()
    {
        return $this->hasOne(Libros::className(), ['id' => 'libro_id'])->inverseOf('seguimientos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(LibrosEstados::className(), ['id' => 'estado_id'])->inverseOf('seguimientos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id'])->inverseOf('seguimientos');
    }
}
