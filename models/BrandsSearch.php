<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Brands;

/**
 * BrandsSearch represents the model behind the search form of `app\models\Brands`.
 */
class BrandsSearch extends Brands
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'img_id'], 'integer'],
            [['name', 'description', 'urlname', 'date_c', 'user_c'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Brands::find();

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
            'date_c' => $this->date_c,
            'user_c' => $this->user_c,
            'img_id' => $this->img_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'urlname', $this->urlname]);

        return $dataProvider;
    }
}