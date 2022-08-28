<?php

namespace app\models;

use app\models\Images;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ImagesSearch represents the model behind the search form of `app\models\Images`.
 */
class ImagesSearch extends Images
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'size', 'hash'], 'integer'],
            [['path', 'description', 'date_c'], 'safe'],
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
        $query = Images::find();
        
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
            'size' => $this->size,
            'date_c' => $this->date_c,
            'hash' => $this->hash,
        ]);
        
        $query->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'description', $this->description]);
        
        return $dataProvider;
    }
}
