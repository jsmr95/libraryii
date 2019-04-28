<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "votos".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $libro_id
 * @property string $voto
 *
 * @property Libros $libro
 * @property UsuariosId $usuario
 */
class Votos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'votos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'libro_id'], 'default', 'value' => null],
            [['usuario_id', 'libro_id'], 'integer'],
            [['voto'], 'number'],
            [['libro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Libros::className(), 'targetAttribute' => ['libro_id' => 'id']],
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
            'voto' => 'Voto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibro()
    {
        return $this->hasOne(Libros::className(), ['id' => 'libro_id'])->inverseOf('votos');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id'])->inverseOf('votos');
    }
}
