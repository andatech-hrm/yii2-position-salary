<?php

namespace andahrm\positionSalary\models;

use Yii;
use yii\db\ActiveRecord;
//use andahrm\edoc\behavior\UploadBehavior;
/**
 * This is the model class for table "edoc".
 *
 * @property integer $id
 * @property string $code
 * @property string $date_code
 * @property string $title
 * @property string $file
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property PersonPostionSalary[] $personPostionSalaries
 */
class Edoc extends \andahrm\edoc\models\Edoc
{
    
}
