<?php

namespace andahrm\positionSalary\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\positionSalary\models\PersonPositionSalary;

/**
 * PersonPositionSalarySearch represents the model behind the search form about `andahrm\positionSalary\models\PersonPositionSalary`.
 */
class PersonPositionSalarySearch extends PersonPositionSalary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'position_id', 'edoc_id', 'status', 'level', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
        $query = PersonPositionSalary::find();

        // add conditions that should always apply here
        //$query->with('edoc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['adjust_date'=>SORT_DESC]]
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
            'adjust_date' => $this->adjust_date,
            'status' => $this->status,
            'level' => $this->level,
            'salary' => $this->salary,
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
