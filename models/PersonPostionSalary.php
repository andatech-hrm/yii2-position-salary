<?php

namespace andahrm\positionSalary\models;

use Yii;

use andahrm\edoc\models\Edoc;
use andahrm\person\models\Person;
use andahrm\structure\models\Position;

/**
 * This is the model class for table "person_postion_salary".
 *
 * @property integer $user_id
 * @property string $adjust_date
 * @property string $title
 * @property integer $status
 * @property string $step
 * @property integer $position_id
 * @property integer $level
 * @property string $salary
 * @property integer $edoc_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Edoc $edoc
 * @property Person $user
 * @property Position $position
 */
class PersonPostionSalary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_postion_salary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'adjust_date', 'title', 'status', 'position_id', 'level', 'salary', 'edoc_id'], 'required'],
            [['user_id', 'status', 'position_id', 'level', 'edoc_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['adjust_date'], 'safe'],
            [['salary'], 'number'],
            [['title'], 'string', 'max' => 255],
            [['step'], 'string', 'max' => 4],
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
            'user_id' => Yii::t('andahrm/postion-salary', 'User ID'),
            'adjust_date' => Yii::t('andahrm/postion-salary', 'ลงวันที่'),
            'title' => Yii::t('andahrm/postion-salary', 'Title'),
            'status' => Yii::t('andahrm/postion-salary', 'Status'),
            'step' => Yii::t('andahrm/postion-salary', 'Step'),
            'position_id' => Yii::t('andahrm/postion-salary', 'Position ID'),
            'level' => Yii::t('andahrm/postion-salary', 'Level'),
            'salary' => Yii::t('andahrm/postion-salary', 'อัตราเงินเดือน'),
            'edoc_id' => Yii::t('andahrm/postion-salary', 'เอกสารอ้างอิง'),
            'created_at' => Yii::t('andahrm/postion-salary', 'Created At'),
            'created_by' => Yii::t('andahrm/postion-salary', 'Created By'),
            'updated_at' => Yii::t('andahrm/postion-salary', 'Updated At'),
            'updated_by' => Yii::t('andahrm/postion-salary', 'Updated By'),
        ];
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
}
