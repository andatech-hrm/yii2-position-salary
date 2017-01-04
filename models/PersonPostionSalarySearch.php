<?php

namespace andahrm\positionSalary\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\positionSalary\models\PersonPostionSalary;

/**
 * PersonPostionSalarySearch represents the model behind the search form about `andahrm\positionSalary\models\PersonPostionSalary`.
 */
class PersonPostionSalarySearch extends PersonPostionSalary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'position_id', 'level', 'edoc_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['adjust_date', 'title', 'step'], 'safe'],
            [['salary'], 'number'],
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
        $query = PersonPostionSalary::find();

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
            'adjust_date' => $this->adjust_date,
            'status' => $this->status,
            'position_id' => $this->position_id,
            'level' => $this->level,
            'salary' => $this->salary,
            'edoc_id' => $this->edoc_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'step', $this->step]);

        return $dataProvider;
    }
}
