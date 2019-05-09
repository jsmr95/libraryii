<?php

namespace app\models;

/**
 * This is the model class for table "estados".
 *
 * @property int $id
 * @property int $usuario_id
 * @property string $estado
 * @property string $created_at
 *
 * @property UsuariosId $usuario
 */
class Estados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['estado'], 'required'],
            [['created_at'], 'safe'],
            [['estado'], 'string', 'max' => 255],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['created_at'], 'default', 'value' => function () {
                return date('Y-m-d h:i:s');
            }],
    ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario',
            'estado' => 'Estado',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id'])->inverseOf('estados');
    }

    /**
     * Función para consultar si un usuario ha hecho lyb en algun estado.
     * @param mixed $usuarioId
     * @param mixed $estadoId
     * @return bool true|false para saber si ha hecho lyb en ese estado.
     */
    public function consultaLyb($usuarioId, $estadoId)
    {
        $fila = EstadosLyb::find()->where(['usuario_id' => $usuarioId])
            ->andWhere(['estado_id' => $estadoId])->one();
        if ($fila) {
            return true;
        }
        return false;
    }
}
