<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * EstadosSearch represents the model behind the search form of `app\models\Estados`.
 */
class EstadosSearch extends Estados
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id'], 'integer'],
            [['estado', 'created_at', 'usuario.usersFavs', 'libro_id', 'libro.titulo'], 'safe'],
        ];
    }

    /**
     * Funcion para añadir atributo nuevo.
     * @return array Array resultante de de los nuevos atributos.
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['libro.titulo']);
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
        $id = Yii::$app->user->id;
        $query = Estados::find()
        ->joinWith('libro')
        ->joinWith('usuario.usersFavs u', true, 'LEFT JOIN')
        ->where(['estados.usuario_id' => $id])
        ->orWhere("u.usuario_id IN (SELECT usuario_fav AS seguidor FROM users_favs WHERE usuario_id = $id)");
        // ->orWhere('u.usuario_id IN (SELECT usuario_id FROM estados_lyb WHERE usuario_id = seguidor)');
        //falta esto, para ver los lybs de los seguidores mios

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['libro.titulo'] = [
            'asc' => ['libros.titulo' => SORT_ASC],
            'desc' => ['libros.titulo' => SORT_DESC],
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
            'usuario_id' => $this->usuario_id,
            'created_at' => $this->created_at,
            'libro_id' => $this->libro_id,
        ]);

        $query->andFilterWhere(['ilike', 'estado', $this->estado])
        ->andFilterWhere(['ilike', 'libros.titulo', $this->getAttribute('libro.titulo')]);
        // ->andFilterWhere(['ilike', 'usuario.usersFavs',
        //                   $this->getAttribute('usuario.usersFavs'), ]);

        return $dataProvider;
    }
}
