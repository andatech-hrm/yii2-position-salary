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
use andahrm\structure\models\FiscalYear;

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
            //'format'=>'html',
            //'value'=>'user.fullname',
            'content'=> function($model){
                return $model->user->fullname;
            },
        ],
         [
            'attribute'=>'position_id',
            'format'=>'html',
            'content'=> function($model){
                return $model->position->title."<br/><small>".$model->position->code."</small>";
            },
        ],
        [
            'attribute'=>'step_adjust',
            'contentOptions'=>['class'=>'text-right'],
            'content'=> function($model) use ($modelAssign){
                return $modelAssign->step_adjust[$model->user_id]?$modelAssign->step_adjust[$model->user_id]:0;
            },
        ],
        [
            'attribute'=>'level',
            'contentOptions'=>['class'=>'text-right'],
            'format'=>'html',
            'content'=> function($model) use ($modelAssign){
                return Confirm::Tobe($modelAssign->level[$model->user_id],$modelAssign->new_level[$model->user_id]);
            },
        ],
       
       
        
        [
            'attribute'=>'salary',
            'contentOptions'=>['class'=>'text-right'],
            'format'=>'raw',
            'content'=> function($model) use ($modelAssign){
                return Confirm::Tobe($modelAssign->salary[$model->user_id],$modelAssign->new_salary[$model->user_id]);
            },
        ],
        [
            'attribute'=>'edoc_id',
            'content'=>function($model) use ($modelTopic){
                return $modelTopic->edoc->title."<br/>".$modelTopic->edoc->code."<br/>"
                .Yii::$app->formatter->asDate($modelTopic->edoc->date_code);
            }
        ]
         
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

