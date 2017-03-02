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

$this->title = Yii::t('andahrm/leave', 'Confirm Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Position Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Create New'), 'url' => ['create','step'=>'reset']];
$this->params['breadcrumbs'][] = $this->title;

//$modelSelect$modelSelect->leave_type_id;


$modelTopic= $event->sender->read('topic')[0];
$modelPerson= $event->sender->read('person')[0];
$modelAssign= $event->sender->read('assign')[0];

// echo "<pre>";
//  print_r($modelAssign);
// exit();
?>

<?php echo WizardMenu::widget([
      'currentStepCssClass' => 'selected',
      'step' => $event->step,
      'wizard' => $event->sender,
      'options' => ['class'=>'wizard_steps anchor']
    ]);?>

<div class="leave-form">
    <hr/>
    <?php $form = ActiveForm::begin(); 
    //$model->status = 1;
    echo $form->field($model, 'status')->hiddenInput()->label(false);
    ?>
    
    <div class="row">
    <div class="col-sm-6">
    <?php
    echo DetailView::widget([
        'model'=>$modelTopic,
        'template'=>'<tr><th class="text-right">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'title',
            [
                'attribute'=>'status',
                'value'=>$modelTopic->statusLabel,
                ],
            [
                'attribute'=>'edoc_id',
                'format'=>'raw',
                'value'=>function($model){
                    return $model->edoc->title."<br/>".$model->edoc->code."<br/>"
                    .Yii::$app->formatter->asDate($model->edoc->date_code);
                }
            ],
             [
                'attribute'=>'adjust_date',
                'value'=>Helper::dateBuddhistFormatter($modelTopic->adjust_date),
                ],
            
            
         ],
        ]);
        ?>
    </div>       
    </div>       
        
        <?php
    
  
  
  echo GridView::widget([
            'dataProvider' => Assign::getPerson($modelPerson),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'user_id',
                    //'format'=>'html',
                    //'value'=>'user.fullname',
                    'content'=> function($model) use ($form){
                        return $model->user->fullname;
                    },
                ],
                 [
                    'attribute'=>'position_id',
                    'format'=>'html',
                    'content'=> function($model) use ($form){
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

     <?=$this->render('button',['event'=>$event]);?>
     
    <?php ActiveForm::end(); ?>

</div>

