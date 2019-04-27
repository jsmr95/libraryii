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
     * Escenario donde se inserta un autor.
     * @var string
     */
    const SCENARIO_CREATE = 'create';

    /**
     * Escenario donde un autor se modifica.
     * @var string
     */
    const SCENARIO_UPDATE = 'update';

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

    /**
     * Función para obtener todos los libros de un autor.
     * @return array|null Array de libros de ese autor.
     */
    public function librosAutor()
    {
        $libros = Libros::find()->where(['autor_id' => $this->id])->all();
        return $libros;
    }

    /**
     * Funcion para consultar si el usuario logueado, sigue o no, al autor
     * que está consultando.
     * @param  int $miId id del usuario logueado
     * @param  int $autorId id del autor al que visita
     * @return string res cadena que hará mostrar un corazón lleno (lo sigue)
     * o un corazon vacío (no lo sigue).
     */
    public function consultaAutorSeguido($miId, $autorId)
    {
        $fila = AutoresFavs::find()->where(['usuario_id' => $miId])
            ->andWhere(['autor_id' => $autorId])->one();
        if ($fila) {
            return '';
        }
        return '-empty';
    }

    /**
     * Funcion que es llamada antes de insertar o actualizar un registro.
     * @param  bool $insert true->insert, false->update
     * @return bool true->inserccion o modificación llevada a cabo, false-> cancelado
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if (!$insert) {
            if ($this->imagen === '') {
                $this->imagen = $this->getOldAttribute('imagen');
            }
        }
        return true;
    }
}
