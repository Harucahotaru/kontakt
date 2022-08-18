<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ControllerRules;

/**
 * ControllerRulesSearch represents the model behind the search form of `app\models\ControllerRules`.
 */
class ControllerRulesSearch extends ControllerRules
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'allow', 'user_creator'], 'integer'],
            [['controller_name', 'action', 'role', 'date_m'], 'safe'],
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
        $query = ControllerRules::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'allow' => $this->allow,
            'user_creator' => $this->user_creator,
            'date_m' => $this->date_m,
        ]);

        $query->andFilterWhere(['like', 'controller_name', $this->controller_name])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'role', $this->role]);

        return $dataProvider;
    }
}
