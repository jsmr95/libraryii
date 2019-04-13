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
            [['estado', 'created_at', 'usuario.usersFavs'], 'safe'],
        ];
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
        $query = Estados::find()->joinWith('usuario.usersFavs u', true, 'INNER JOIN')
        ->where(['estados.usuario_id' => $id])
        ->orWhere("u.usuario_id IN (SELECT usuario_fav FROM users_favs WHERE usuario_id = $id)");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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
        ]);

        $query->andFilterWhere(['ilike', 'estado', $this->estado]);
        // ->andFilterWhere(['ilike', 'usuario.usersFavs',
        //                   $this->getAttribute('usuario.usersFavs'), ]);

        return $dataProvider;
    }
}
