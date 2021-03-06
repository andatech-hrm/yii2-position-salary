<?php

namespace andahrm\positionSalary\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use andahrm\datepicker\behaviors\DateBuddhistBehavior;
use andahrm\datepicker\behaviors\YearBuddhistBehavior;
###
use andahrm\structure\models\PositionOld;
use andahrm\edoc\models\Edoc;
use andahrm\person\models\Person;

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
class PersonPositionSalaryOld extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'person_position_salary_old';
    }

    /**
     * @inheritdoc
     */
    function behaviors() {

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
    public function rules() {
        return [
            //[['user_id', 'position_old_id', 'adjust_date', 'title', 'status', 'level', 'salary'], 'required'],
            [['user_id', 'position_old_id', 'adjust_date', 'status', 'level', 'salary'], 'required'],
            [['user_id', 'edoc_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['adjust_date', 'new_edoc', 'position_old_id'], 'safe'],
            [['step_adjust', 'step', 'salary'], 'number'],
            [['level'], 'string', 'max' => 5],
            //[['title'], 'string', 'max' => 255],
            [['position_old_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionOld::className(), 'targetAttribute' => ['position_old_id' => 'id']],
        ];
    }

    public $position_id;

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => Yii::t('andahrm/position-salary', 'User ID'),
            'position_old_id' => Yii::t('andahrm/position-salary', 'Position Old ID'),
            'position_id' => Yii::t('andahrm/position-salary', 'Position ID'),
            'edoc_id' => Yii::t('andahrm/position-salary', 'Edoc ID'),
            'adjust_date' => Yii::t('andahrm/position-salary', 'Adjust Date'),
            'title' => Yii::t('andahrm/position-salary', 'Title'),
            'title-list' => Yii::t('andahrm/position-salary', 'Title List'),
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

    public function attributeHints() {
        return [
            'position_old_id' => Yii::t('andahrm/position-salary', 'Press enter when cannot find.'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositionOld() {
        return $this->hasOne(PositionOld::className(), ['id' => 'position_old_id']);
    }

    public function getExists() {
        return self::find()->where([
                    'user_id' => $this->user_id,
                    'position_old_id' => $this->position_old_id,
                    'edoc_id' => $this->edoc_id,
                ])->exists();
    }

    public function getPosition() {
        return $this->hasOne(PositionOld::className(), ['id' => 'position_old_id']);
    }

    public function getEdoc() {
        return $this->hasOne(Edoc::className(), ['id' => 'edoc_id']);
    }

    public function getPositionId() {
        return $this->position_old_id;
    }

    const STATUS_FIRST_TIME = 1; #บรรจุแรกเข้า
    const STATUS_ADJUST = 2; #ปรับเงินเดือน
    const STATUS_MOVE = 3; #ย้ายสายงาน
    const STATUS_LEAVE = 4; #สินสุดการจ้าง
    const STATUS_TRANSFER = 5; #โอน

    public static function itemsAlias($key) {
        $items = [
            'status' => [
                self::STATUS_FIRST_TIME => Yii::t('andahrm/position-salary', 'First time'),
                self::STATUS_ADJUST => Yii::t('andahrm/position-salary', 'Adjust salary'),
                self::STATUS_MOVE => Yii::t('andahrm/position-salary', 'Move line'),
                self::STATUS_LEAVE => Yii::t('andahrm/position-salary', 'Leave'),
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

    /* public $round;

      public function afterSave( $insert, $changedAttributes )
      {
      ++$this->round;
      // Place your custom code here
      if($this->round == 1){
      // echo $this->status;
      // echo $this->position_old_id;
      switch($this->status){
      case self::STATUS_FIRST_TIME:
      $this->title = $this->position->title;
      $this->save(false);
      //exit();
      break;
      default:
      $this->title = $this->edoc->title;
      $this->save(false);
      //exit();
      break;
      }
      parent::afterSave( $insert, $changedAttributes );
      }
      } */

    public function getTitle() {
        $str = '';
        switch ($this->status) {
            case self::STATUS_FIRST_TIME:
                $str = $this->position->title;
                //exit();
                break;
            case self::STATUS_MOVE:
                $arr_str[] = $this->position->title;
                $arr_str[] = $this->edoc->title;
                $arr_str = array_filter($arr_str);
                $str = implode("<br/>", $arr_str);
                break;
            default:
                $arr_str[] = $this->position->title;
                $arr_str[] = $this->edoc->title;
                $arr_str = array_filter($arr_str);
                $str = implode("<br/>", $arr_str);
                //exit();
                break;
        }
        return $str;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }

}
