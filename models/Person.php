<?php

namespace andahrm\positionSalary\models;

use Yii;
use yii\data\ActiveDataProvider;
use andahrm\positionSalary\models\PersonPositionSalary;
use yii\base\Model;
/**
 * This is the model class for table "insignia_person".
 *
 * @property integer $insignia_request_id
 * @property integer $user_id
 * @property integer $position_level_id
 * @property string $position_current_date
 * @property string $salary
 * @property integer $position_id
 * @property integer $insignia_request_id_last
 * @property integer $insignia_type_id
 * @property string $feat
 * @property string $note
 *
 * @property InsigniaType $insigniaType
 * @property InsigniaRequest $insigniaRequest
 * @property InsigniaRequest $insigniaRequestIdLast
 */
class Person extends Model
{
    public function rules()
    {
        return [
            [[
                //'select_person',
                'selection',
            ], 'required'],
        ];
    }
    
    public $select_person;
    public $selection;
    public $section_id;
    public $percent;
    public $previous;
    public $person_type_id;
    public $position_line_id;
    public $dataPrevious;
    public $dataStepCal;
    
     public function scenarios(){
          $scenarios = parent::scenarios();
          $scenarios['insert'] = [
              'select_person',
              'section_id',
              'person_type_id',
              'position_line_id',
              ];
          return $scenarios;
    }
    
    
    
    public static function getPerson($event){
        $data = $event->sender->read('topic')[0];
        // print_r($data);
        // exit();
        // $person_type_id = $data->person_type_id;
        // $position_id = $data->position_id;
        // $position_level_id = $data->position_level_id;
       // $year = $data->year;
        $query = PersonPositionSalary::find()->joinWith('position')
                //->where(['year'=>$year])
                // ->andFilterWhere(['position.person_type_id'=>$person_type_id])
                // ->andFilterWhere(['position.id'=>$position_id])
                // ->andFilterWhere(['position.position_level_id'=>$position_level_id])
                ->groupBy([
                    //'position.id',
                    'user_id',
                    
                    
                ])
                ->orderBy(['position_id'=>SORT_ASC,'adjust_date'=>SORT_ASC]);
                
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'pageSize' => 10,
            ],
            // 'sort' => [
            //     'defaultOrder' => [
            //         'created_at' => SORT_DESC,
            //         'title' => SORT_ASC, 
            //     ]
            // ],
        ]);
        
        return $provider;
    }
    
}
