<?php

namespace app\models;

/**
 * This is the model class for table "comentarios".
 *
 * @property int $id
 * @property string $texto
 * @property int $usuario_id
 * @property int $libro_id
 * @property int $comentario_id
 * @property string $created_at
 *
 * @property Comentarios $comentario
 * @property Comentarios[] $comentarios
 * @property Libros $libro
 * @property UsuariosId $usuario
 */
class Comentarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['texto'], 'required'],
            [['texto'], 'string'],
            [['usuario_id', 'libro_id', 'comentario_id'], 'default', 'value' => null],
            [['usuario_id', 'libro_id', 'comentario_id'], 'integer'],
            [['created_at'], 'safe'],
            [['comentario_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => ['comentario_id' => 'id']],
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
            'texto' => 'Texto',
            'usuario_id' => 'Usuario',
            'libro_id' => 'Libro',
            'comentario_id' => 'Comentario',
            'created_at' => 'Creado',
        ];
    }

    /**
     * Función para sacar los comentarios hijos.
     * @return array array de comentarios hijos
     */
    public function comentariosHijos()
    {
        return self::find()
            ->where(['comentario_id' => $this->id])
            ->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentario()
    {
        return $this->hasOne(self::className(), ['id' => 'comentario_id'])->inverseOf('comentarios');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(self::className(), ['comentario_id' => 'id'])->inverseOf('comentario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibro()
    {
        return $this->hasOne(Libros::className(), ['id' => 'libro_id'])->inverseOf('comentarios');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id'])->inverseOf('comentarios');
    }
}
