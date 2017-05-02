<?php

namespace andahrm\positionSalary\models;

use Yii;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

use andahrm\person\models\Person;
use andahrm\edoc\models\Edoc;
use andahrm\structure\models\Position;
/**
 * This is the model class for table "person_position_salary".
 *
 * @property integer $user_id
 * @property integer $position_id
 * @property integer $edoc_id
 * @property string $adjust_date
 * @property string $title
 * @property integer $status
 * @property string $step
 * @property integer $level
 * @property string $salary
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Edoc $edoc
 * @property Person $user
 * @property Position $position
 */
class Topic extends PersonPositionSalary
{
  
   //public $person_type_id;
    public function scenarios(){
      $scenarios = parent::scenarios();
      $scenarios['insert'] = [ 'edoc_id', 'adjust_date', 'title', 'status','person_type_id'];
      return $scenarios;
    }
   
   
   public static function itemsAlias($key) {
        $items = [
            'status1' => [
                //self::STATUS_FIRST_TIME => Yii::t('andahrm/position-salary', 'First time'),
                self::STATUS_ADJUST => Yii::t('andahrm/position-salary',  'Adjust salary'),
                self::STATUS_MOVE => Yii::t('andahrm/position-salary',  'Move line'),
                self::STATUS_LEAVE => Yii::t('andahrm/position-salary',  'Leave'),
                self::STATUS_TRANSFER => Yii::t('andahrm/position-salary',  'Transfer'),
            ],
            'status2' => [
                //self::STATUS_FIRST_TIME => Yii::t('andahrm/position-salary', 'First time'),
                self::STATUS_ADJUST => Yii::t('andahrm/position-salary',  'Adjust salary'),
                self::STATUS_MOVE => Yii::t('andahrm/position-salary',  'Move line'),
                self::STATUS_LEAVE => Yii::t('andahrm/position-salary',  'Leave'),
            ],
        ];
        return ArrayHelper::getValue($items, $key, []);
    }
    
    public function getStatusLabel() {
        return ArrayHelper::getValue($this->getItemStatus(), $this->status);
    }

    public static function getItemStatus1() {
          return self::itemsAlias('status2');
    }
    public static function getItemStatus2() {
          return self::itemsAlias('status2');
    }
    
}
