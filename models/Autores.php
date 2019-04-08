<?php

namespace app\models;

/**
 * This is the model class for table "autores".
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $imagen
 *
 * @property AutoresFavs[] $autoresFavs
 * @property Libros[] $libros
 */
class Autores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'autores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion'], 'required'],
            [['nombre', 'descripcion', 'imagen'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoresFavs()
    {
        return $this->hasMany(AutoresFavs::className(), ['autor_id' => 'id'])->inverseOf('autor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibros()
    {
        return $this->hasMany(Libros::className(), ['autor_id' => 'id'])->inverseOf('autor');
    }
}
