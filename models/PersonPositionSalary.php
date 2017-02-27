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
class PersonPositionSalary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_position_salary';
    }
  
  /**
     * @inheritdoc
     */
    function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'position_id', 'edoc_id', 'adjust_date', 'title', 'status', 'level', 'salary'], 'required'],
            [['user_id', 'position_id', 'edoc_id', 'status', 'level', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['adjust_date'], 'safe'],
            [['step_adjust', 'salary','step'], 'number'],
            [['title'], 'string', 'max' => 255],
            //[['step'], 'string', 'max' => 4],
            [['edoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edoc::className(), 'targetAttribute' => ['edoc_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['position_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('andahrm/position-salary', 'User ID'),
            'position_id' => Yii::t('andahrm/position-salary', 'Position ID'),
            'edoc_id' => Yii::t('andahrm/position-salary', 'Edoc ID'),
            'adjust_date' => Yii::t('andahrm/position-salary', 'Adjust Date'),
            'title' => Yii::t('andahrm/position-salary', 'Title'),
            'status' => Yii::t('andahrm/position-salary', 'Status'),
            'step' => Yii::t('andahrm/position-salary', 'Step'),
            'step_adjust' => Yii::t('andahrm/position-salary', 'Step Total'), 
            'level' => Yii::t('andahrm/position-salary', 'Level'),
            'salary' => Yii::t('andahrm/position-salary', 'Salary'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }
    
    public function scenarios(){
      $scenarios = parent::scenarios();
      
      $scenarios['new-person'] = [
          //'user_id',
              'position_id', 
              'edoc_id', 
              'salary', 
              'user_id', 
              'level'
          ];
      
      return $scenarios;
    }
    
    
   const STATUS_LEAVE = 0; #สินสุดการจ้าง
   const STATUS_FIRST_TIME = 1; #บรรจุแรกเข้า
   const STATUS_ADJUST = 2; #ปรับเงินเดือน
   const STATUS_MOVE = 3; #ย้ายสายงาน
    
    public static function itemsAlias($key) {
        $items = [
            'status' => [
                self::STATUS_FIRST_TIME => Yii::t('andahrm/position-salary', 'First time'),
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

    public static function getItemStatus() {
          return self::itemsAlias('status');
     }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdoc()
    {
        return $this->hasOne(Edoc::className(), ['id' => 'edoc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['id' => 'position_id']);
    }
    
    public function getPersonPosition()
    {
        return $this->hasOne(PersonPosition::className(), ['user_id' => 'user_id']);
    }
    
    public function getAssessment()
    {
        return $this->hasOne(Assessment::className(), ['user_id' => 'user_id']);
    }
    
}
