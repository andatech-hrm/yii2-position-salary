<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use kartik\widgets\DatePicker;

use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveType;
use andahrm\leave\models\LeaveDayOff;

use andahrm\leave\models\PersonLeave;
use andahrm\structure\models\Position;

use backend\widgets\WizardMenu;
use andahrm\positionSalary\models\Assign;
use andahrm\positionSalary\models\Confirm;

use andahrm\setting\models\Helper;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */


$modelTopic= $event->sender->read('topic')[0];
$modelPerson= $event->sender->read('person')[0];
$modelAssign= $event->sender->read('assign')[0];

// echo "<pre>";
//  print_r($modelAssign);
// exit();
?>

   
        
        <?php
    
  
  
echo GridView::widget([
    'dataProvider' => Assign::getPerson($modelPerson),
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute'=>'user_id',
            'format'=>'html',
            //'value'=>'user.fullname',
            'content'=> function($model) {
                return $model->user->fullname;
            },
        ],
         [
            'attribute'=>'new_position_id',
            'format'=>'html',
            'content'=> function($model) use ($modelAssign){
                $newPosition = $model->getNewPosition($modelAssign->new_position_id[$model->user_id]);
            //   echo $modelAssign->new_position_id[$model->user_id];
            //   exit();
                return Confirm::Tobe($model->positionTitleCode,$newPosition->titleCode);
                //return $model->positionTitleCode;
            },
        ],
        
        [
            'attribute'=>'level',
            'contentOptions'=>['class'=>'text-right'],
            'format'=>'html',
            'content'=> function($model) use ($modelAssign){
                return Confirm::Tobe($model->level,$modelAssign->level[$model->user_id]);
            },
        ],
       
        [
            'attribute'=>'salary',
            'contentOptions'=>['class'=>'text-right'],
            'format'=>'raw',
            'content'=> function($model) use ($modelAssign){
                return Confirm::Tobe($model->salary,$modelAssign->salary[$model->user_id]);
            },
        ],
        
        
        [
            'attribute'=>'start_date',
            'format'=>'raw',
            'value'=>function($model) use ($modelAssign){
                return Helper::dateBuddhistFormatter($modelAssign->start_date[$model->user_id]);
            }
        ],
        
        [
            'attribute'=>'end_date',
            'format'=>'raw',
            'value'=>function($model) use ($modelAssign){
                return Helper::dateBuddhistFormatter($modelAssign->end_date[$model->user_id]);
            }
        ],
         
        //  [
        //     'attribute'=>'adjust_date',
        //     'content'=> function($model){
        //         return Yii::$app->formatter->asDate($model->adjust_date)
        //         .Html::hiddenInput("Assign[current_adjust_date][{$model->user_id}]",
        //             $model->adjust_date
        //             );
        //     },
        //     ],
    ]
]);
?>

