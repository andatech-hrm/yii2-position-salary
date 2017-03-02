<?php

namespace andahrm\positionSalary\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\positionSalary\models\PersonContract;

/**
 * PersonContractSearch represents the model behind the search form of `andahrm\positionSalary\models\PersonContract`.
 */
class PersonContractSearch extends PersonContract
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'position_id', 'edoc_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = PersonContract::find();

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
            'user_id' => $this->user_id,
            'position_id' => $this->position_id,
            'edoc_id' => $this->edoc_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
