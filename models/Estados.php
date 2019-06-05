<?php

namespace app\models;

use DateTime;
use DateTimeZone;

/**
 * This is the model class for table "estados".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $libro_id
 * @property string $estado
 * @property string $created_at
 *
 * @property UsuariosId $usuario
 * @property EstadosFavs[] $estadosFavs
 * @property EstadosLyb[] $estadosLybs
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
            [['usuario_id', 'libro_id'], 'integer'],
            [['estado'], 'required'],
            // [['created_at'], 'safe'],
            [['estado'], 'string', 'max' => 255],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            // [['created_at'], 'default', 'value' => function () {
            //     $ahora = date('Y-m-d h:i:s');
            //     $dt = new DateTime($ahora, new DateTimeZone('Europe/London'));
            //     return $dt->format('Y-m-d h:i:s');
            // }],
            [['libro_id'], 'default', 'value' => function () {
                return null;
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
            'usuario_id' => 'Usuario ID',
            'estado' => 'Estado',
            'created_at' => 'Created At',
            'libro_id' => 'Libro',
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
     * @return \yii\db\ActiveQuery
     */
    public function getLibro()
    {
        return $this->hasOne(Libros::className(), ['id' => 'libro_id'])->inverseOf('estados');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadosFavs()
    {
        return $this->hasMany(EstadosFavs::className(), ['estado_id' => 'id'])->inverseOf('estado');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadosLybs()
    {
        return $this->hasMany(EstadosLyb::className(), ['estado_id' => 'id'])->inverseOf('estado');
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

    /**
     * Función para consultar si un usuario ha hecho fav en algun estado.
     * @param mixed $usuarioId
     * @param mixed $estadoId
     * @return string ''|'-emtpy' para saber si ha hecho fav en ese estado.
     */
    public function consultaFav($usuarioId, $estadoId)
    {
        $fila = EstadosFavs::find()->where(['usuario_id' => $usuarioId])
            ->andWhere(['estado_id' => $estadoId])->one();
        if ($fila) {
            return '';
        }
        return '-empty';
    }
}
