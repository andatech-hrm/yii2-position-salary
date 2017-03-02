<?php

namespace andahrm\positionSalary\models;

use Yii;
use yii\data\ActiveDataProvider;
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
class Assign extends PersonPositionSalary
{
    public function rules()
    {
        return [
            [['user_id', 'position_id', 'level', 'salary','step'], 'required'],
            // [['user_id', 'position_id', 'edoc_id', 'status', 'level', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            // [['adjust_date'], 'safe'],
            // [['step_adjust', 'salary','step'], 'number'],
            // [['title'], 'string', 'max' => 255],
          
        ];
    }
    
    public $new_level;
    public $new_salary;
    public $new_position_id;
    
     public function scenarios(){
          $scenarios = parent::scenarios();
          $scenarios['insert'] = [
             'user_id', 'step' ,'salary', 'position_id', 'step_adjust', 'level',
              ];
          return $scenarios;
    }
    
    public function attributeLabels()
    {
        $label = parent::attributeLabels();
        $newLabel = [];
        $newLabel = [
            'new_level' => Yii::t('andahrm/position-salary', 'New Level'),
            'new_salary' => Yii::t('andahrm/position-salary', 'New Salary'),
            'new_position_id' => Yii::t('andahrm/position-salary', 'New Position'),
        ];
        return array_merge($label,$newLabel);
    }
    
    
    
    
    
    public static function getPerson($data){
        //$data = $event->sender->read('topic')[0];
        //print_r($data);
        // exit();
        // $person_type_id = $data->person_type_id;
        // $position_id = $data->position_id;
        // $position_level_id = $data->position_level_id;
       // $year = $data->year;
       
      
        $query = self::find()->joinWith('position')
                //->where(['year'=>$year])
                 ->andFilterWhere(['user_id'=>$data->selection])
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
    
    
    
    
    // public function beforeValidate()
    // {
    //      if (parent::beforeValidate()) {
    //         //  print_r(Yii::$app->request->post());
    //         // exit();
    //         return true;
    //     }
    //     return false;
    // }
}
