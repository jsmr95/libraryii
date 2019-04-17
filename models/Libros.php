<?php

namespace app\models;

/**
 * This is the model class for table "libros".
 *
 * @property int $id
 * @property string $titulo
 * @property string $isbn
 * @property string $imagen
 * @property string $anyo
 * @property string $sinopsis
 * @property string $url_compra
 * @property int $autor_id
 * @property int $genero_id
 *
 * @property Comentarios[] $comentarios
 * @property Autores $autor
 * @property Generos $genero
 * @property LibrosFavs[] $librosFavs
 */
class Libros extends \yii\db\ActiveRecord
{
    /**
     * Escenario donde se inserta un libro.
     * @var string
     */
    const SCENARIO_CREATE = 'create';

    /**
     * Escenario donde un libro se modifica.
     * @var string
     */
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libros';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'isbn', 'anyo', 'sinopsis', 'url_compra'], 'required'],
            [['anyo'], 'number'],
            [['isbn'], 'unique'],
            [['autor_id', 'genero_id'], 'default', 'value' => null],
            [['autor_id', 'genero_id'], 'integer'],
            [['titulo', 'isbn', 'sinopsis', 'url_compra'], 'string', 'max' => 255],
            [['autor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Autores::className(), 'targetAttribute' => ['autor_id' => 'id']],
            [['genero_id'], 'exist', 'skipOnError' => true, 'targetClass' => Generos::className(), 'targetAttribute' => ['genero_id' => 'id']],
            [['url_compra'], 'url'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'isbn' => 'Isbn',
            'anyo' => 'Año',
            'sinopsis' => 'Sinopsis',
            'url_compra' => 'Compra',
            'autor_id' => 'Autor',
            'genero_id' => 'Genero',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::className(), ['libro_id' => 'id'])->inverseOf('libro');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutor()
    {
        return $this->hasOne(Autores::className(), ['id' => 'autor_id'])->inverseOf('libros');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenero()
    {
        return $this->hasOne(Generos::className(), ['id' => 'genero_id'])->inverseOf('libros');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibrosFavs()
    {
        return $this->hasMany(LibrosFavs::className(), ['libro_id' => 'id'])->inverseOf('libro');
    }
}
