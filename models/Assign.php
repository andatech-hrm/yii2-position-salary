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
            // [['user_id', 'position_level_id', 'position_current_date', 'salary', 'position_id', 'insignia_type_id'], 'required'],
            // [['insignia_request_id', 'user_id', 'position_level_id', 'position_id', 'insignia_request_id_last', 'insignia_type_id'], 'integer'],
            // [['position_current_date'], 'safe'],
            // [['salary'], 'number'],
            // [['feat', 'note'], 'string', 'max' => 300],
            // [['insignia_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => InsigniaType::className(), 'targetAttribute' => ['insignia_type_id' => 'id']],
            // [['insignia_request_id'], 'exist', 'skipOnError' => true, 'targetClass' => InsigniaRequest::className(), 'targetAttribute' => ['insignia_request_id' => 'id']],
            // [['insignia_request_id_last'], 'exist', 'skipOnError' => true, 'targetClass' => InsigniaRequest::className(), 'targetAttribute' => ['insignia_request_id_last' => 'id']],
        ];
    }
    
    public $insignia_type_id;
    public $insignia_request_id;
    public $current_insignia_request_id;
    public $current_position_id;
    public $current_salary;
    public $current_step;
    public $current_adjust_date;
    public $note;
    
     public function scenarios(){
          $scenarios = parent::scenarios();
          $scenarios['insert'] = [
              'current_step',
              'current_adjust_date',
              'current_salary', 
              'current_position_id',
              //'current_insignia_type_id',
              'current_insignia_request_id',
              'note',
              'insignia_type_id',
              //'insignia_request_id'
              ];
          return $scenarios;
    }
    
    public function attributeLabels()
    {
        return [
            'insignia_request_id' => Yii::t('andahrm/insignia', 'Insignia Request'),
            'user_id' => Yii::t('andahrm/insignia', 'Person'),
            'position_level_id' => Yii::t('andahrm/insignia', 'Position Level'),
            'step' => Yii::t('andahrm/insignia', 'Step'),
            'last_step' => Yii::t('andahrm/insignia', 'Step'),
            'adjust_date' => Yii::t('andahrm/insignia', 'Last Date'),
            'position_current_date' => Yii::t('andahrm/insignia', 'Last Date'),
            'salary' => Yii::t('andahrm/insignia', 'Salary'),
            'position_id' => Yii::t('andahrm/insignia', 'Last Position'),
            'insignia_request_id_last' => Yii::t('andahrm/insignia', 'Get Last Insignia'),
            'insignia_type_id' => Yii::t('andahrm/insignia', 'This request'),
            'feat' => Yii::t('andahrm/insignia', 'Feat'),
            'note' => Yii::t('andahrm/insignia', 'Note'),
        ];
    }
    
    
    
    
    
    public static function getPerson($data){
        //$data = $event->sender->read('topic')[0];
        //print_r($data);
        // exit();
        // $person_type_id = $data->person_type_id;
        // $position_id = $data->position_id;
        // $position_level_id = $data->position_level_id;
       // $year = $data->year;
       
      
        $query = PersonPositionSalary::find()->joinWith('position')
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
