<?php

namespace andahrm\positionSalary\models;

use Yii;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

use andahrm\person\models\Person;
use andahrm\edoc\models\Edoc;
use andahrm\structure\models\PositionOld;

use andahrm\datepicker\behaviors\DateBuddhistBehavior;
use andahrm\datepicker\behaviors\YearBuddhistBehavior;

/**
 * This is the model class for table "person_contract_old".
 *
 * @property integer $user_id
 * @property integer $position_id
 * @property integer $edoc_id
 * @property string $start_date
 * @property string $end_date
 * @property string $work_date
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Edoc $edoc
 * @property User $user
 * @property PositionOld $position
 */
class PersonContractOld extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_contract_old';
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
            'start_date' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'start_date',
            ],
            'end_date' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'end_date',
            ],
            'work_date' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'work_date',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'position_id', 'edoc_id', 'start_date', 'end_date'], 'required'],
            [['user_id', 'position_id', 'edoc_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'work_date'], 'safe'],
            [['edoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edoc::className(), 'targetAttribute' => ['edoc_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionOld::className(), 'targetAttribute' => ['position_id' => 'id']],
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
            'start_date' => Yii::t('andahrm/position-salary', 'Start Date'),
            'end_date' => Yii::t('andahrm/position-salary', 'End Date'),
            'work_date' => Yii::t('andahrm/position-salary', 'Work Date'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }
    
    public $person_type_id;
    public $section_id;
    public $position_line_id;
    public $position_old;
    

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
        return $this->hasOne(PositionOld::className(), ['id' => 'position_id']);
    }
    
    #check exists record
    public function getExists(){
        return self::find()->where([
            'user_id'=>$this->user_id,
            'position_id'=>$this->position_id,
            'edoc_id'=>$this->edoc_id,
        ])->exists();
    }
    
}
