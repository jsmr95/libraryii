<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "libros_estados".
 *
 * @property int $id
 * @property string $estado
 *
 * @property Seguimientos[] $seguimientos
 */
class LibrosEstados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libros_estados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'required'],
            [['estado'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeguimientos()
    {
        return $this->hasMany(Seguimientos::className(), ['estado_id' => 'id'])->inverseOf('estado');
    }
}
