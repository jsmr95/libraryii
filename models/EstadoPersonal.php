<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estado_personal".
 *
 * @property int $id
 * @property string $contenido
 * @property string $created_at
 * @property int $usuario_id
 *
 * @property UsuariosId $usuario
 */
class EstadoPersonal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estado_personal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contenido'], 'required'],
            [['created_at'], 'safe'],
            [['usuario_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['contenido'], 'string', 'max' => 255],
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
            'contenido' => 'Contenido',
            'created_at' => 'Created At',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id'])->inverseOf('estadoPersonals');
    }
}
