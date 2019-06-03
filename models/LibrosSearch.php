<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LibrosSearch represents the model behind the search form of `app\models\Libros`.
 */
class LibrosSearch extends Libros
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'autor_id', 'genero_id'], 'integer'],
            [['titulo', 'isbn', 'sinopsis', 'url_compra', 'genero.genero', 'autor.nombre'], 'safe'],
            [['anyo'], 'number'],
        ];
    }

    /**
     * Funcion para añadir atributo nuevo.
     * @return array Array resultante de de los nuevos atributos.
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['genero.genero', 'autor.nombre']);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Libros::find()->joinWith('autor')->joinWith('genero');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['genero.genero'] = [
            'asc' => ['generos.genero' => SORT_ASC],
            'desc' => ['generos.genero' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['autor.nombre'] = [
            'asc' => ['autores.nombre' => SORT_ASC],
            'desc' => ['autores.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'anyo' => $this->anyo,
            'autor_id' => $this->autor_id,
            'genero_id' => $this->genero_id,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'isbn', $this->isbn])
            ->andFilterWhere(['ilike', 'sinopsis', $this->sinopsis])
            ->andFilterWhere(['ilike', 'generos.genero', $this->getAttribute('genero.genero')])
            ->andFilterWhere(['ilike', 'autores.nombre', $this->getAttribute('autor.nombre')])
            ->andFilterWhere(['ilike', 'url_compra', $this->url_compra]);

        return $dataProvider;
    }
}
