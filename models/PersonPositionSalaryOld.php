<?php

namespace andahrm\positionSalary\models;

use Yii;

use andahrm\structure\models\PositionOld;
use andahrm\edoc\models\Edoc;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

use kuakling\datepicker\behaviors\DateBuddhistBehavior;
use kuakling\datepicker\behaviors\YearBuddhistBehavior;

/**
 * This is the model class for table "person_position_salary_old".
 *
 * @property integer $user_id
 * @property integer $position_old_id
 * @property integer $edoc_id
 * @property string $adjust_date
 * @property string $title
 * @property integer $status
 * @property string $step_adjust
 * @property string $step
 * @property double $level
 * @property string $salary
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property PositionOld $positionOld
 */
class PersonPositionSalaryOld extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_position_salary_old';
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
            'adjust_date' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'adjust_date',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'position_old_id', 'adjust_date', 'title', 'status', 'level', 'salary'], 'required'],
            [['user_id', 'position_old_id', 'edoc_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['adjust_date','new_edoc'], 'safe'],
            [['step_adjust', 'step', 'level', 'salary'], 'number'],
            [['title'], 'string', 'max' => 255],
            [['position_old_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionOld::className(), 'targetAttribute' => ['position_old_id' => 'id']],
        ];
    }

    public $position_id;
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('andahrm/position-salary', 'User ID'),
            'position_old_id' => Yii::t('andahrm/position-salary', 'Position Old ID'),
            'position_id' => Yii::t('andahrm/position-salary', 'Position ID'),
            'edoc_id' => Yii::t('andahrm/position-salary', 'Edoc ID'),
            'adjust_date' => Yii::t('andahrm/position-salary', 'Adjust Date'),
            'title' => Yii::t('andahrm/position-salary', 'Title'),
            'status' => Yii::t('andahrm/position-salary', 'Status'),
            'step_adjust' => Yii::t('andahrm/position-salary', 'Step Adjust'),
            'step' => Yii::t('andahrm/position-salary', 'Step'),
            'level' => Yii::t('andahrm/position-salary', 'Level'),
            'salary' => Yii::t('andahrm/position-salary', 'Salary'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
            'new_edoc' => Yii::t('andahrm/position-salary', 'New Edoc'),
        ];
    }
    
    
    public $new_edoc;
    
    public function attributeHints()
    {
        return [
            'position_old_id' => Yii::t('andahrm/position-salary', 'Press enter when cannot find.'),
            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositionOld()
    {
        return $this->hasOne(PositionOld::className(), ['id' => 'position_old_id']);
    }
    
    public function getExists(){
        return self::find()->where([
            'user_id'=>$this->user_id,
            'position_old_id'=>$this->position_old_id,
            'edoc_id'=>$this->edoc_id,
        ])->exists();
    }
    
    public function getPosition()
    {
        return $this->hasOne(PositionOld::className(), ['id' => 'position_old_id']);
    }
    
    public function getEdoc()
    {
        return $this->hasOne(Edoc::className(), ['id' => 'edoc_id']);
    }
    
    public function getPositionId()
    {
        return $this->position_old_id;
    }
    
}
