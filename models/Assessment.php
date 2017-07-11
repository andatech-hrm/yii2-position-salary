<?php

namespace andahrm\positionSalary\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use andahrm\datepicker\behaviors\YearBuddhistBehavior;
use andahrm\setting\models\Helper;

use andahrm\person\models\Person;
/**
 * This is the model class for table "assessment".
 *
 * @property integer $user_id
 * @property string $year
 * @property integer $phase
 * @property integer $assessment
 * @property string $percent
 * @property integer $level
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 */
class Assessment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'assessment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'year', 'phase', 'assessment', 'percent', 'level'], 'required'],
            [['user_id', 'phase', 'assessment', 'level', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['year', 'year_th'], 'safe'],
            [['percent'], 'number'],
        ];
    }
    
    function behaviors()
    {
        return [ 
          'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'year' => [
                'class' => YearBuddhistBehavior::className(),
                'attribute' => 'year',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('andahrm/position-salary', 'User ID'),
            'year' => Yii::t('andahrm/position-salary', 'Year'),
            'phase' => Yii::t('andahrm/position-salary', 'Phase'),
            'assessment' => Yii::t('andahrm/position-salary', 'Assessment'),
            'percent' => Yii::t('andahrm/position-salary', 'Percent'),
            'level' => Yii::t('andahrm/position-salary', 'Level'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'yearBuddhist' => Yii::t('andahrm/position-salary', 'Year Th'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }
    
    // public function getYearTh()
    // {
    //     return (intval($this->year) + Helper::YEAR_TH_ADD);
    // }
    
    
    public function getYearBuddhist()
    {
        $yearDistance = $this->getBehavior('year')->yearDistance;
        return (intval($this->year) + $yearDistance);
    }
    
}
