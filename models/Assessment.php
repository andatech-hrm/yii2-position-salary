<?php

namespace andahrm\positionSalary\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

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
            [['year'], 'safe'],
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
            'created_by' => Yii::t('andahrm/position-salary', 'Created By'),
            'created_at' => Yii::t('andahrm/position-salary', 'Created At'),
            'updated_by' => Yii::t('andahrm/position-salary', 'Updated By'),
            'updated_at' => Yii::t('andahrm/position-salary', 'Updated At'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }
    
}
