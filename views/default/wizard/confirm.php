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
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm/leave', 'Confirm Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Create New'), 'url' => ['create','step'=>'reset']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Select Type'), 'url' => ['create','step'=>'select']];
$this->params['breadcrumbs'][] = $this->title;

//$modelSelect$modelSelect->leave_type_id;
//print_r($modelSelect);

$modelTopic= $event->sender->read('topic')[0];
$modelPerson= $event->sender->read('person')[0];
$modelAssign= $event->sender->read('assign')[0];
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
    
    echo DetailView::widget([
        'model'=>$modelTopic
        
        
        
        ]);
    
  
  
  echo GridView::widget([
            'dataProvider' => Assign::getPerson($modelPerson),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'user_id',
                    //'format'=>'html',
                    //'value'=>'user.fullname',
                    'content'=> function($model) use ($form){
                        return $model->user->fullname
                        .$form->field($model,"user_id[{$model->user_id}]")->textInput(['value'=>$model->user_id]);
                    },
                ],
                [
                    'attribute'=>'level',
                    'format'=>'html',
                    'content'=> function($model) use ($form){
                        return $model->level
                        .$form->field($model,"level[{$model->user_id}]")->textInput(['value'=>$model->level]);
                    },
                ],
                [
                    'attribute'=>'position_id',
                    'format'=>'html',
                    'content'=> function($model) use ($form){
                        return $model->position->title."<br/><small>".$model->position->code."</small>"
                        .$form->field($model,"position_id[{$model->user_id}]")->textInput(['value'=>$model->position_id]);
                    },
                ],
                
                [
                    'attribute'=>'step',
                    'content'=> function($model) use ($form){
                        return $form->field($model,"step[{$model->user_id}]")->textInput(['value'=>$model->step]);
                    },
                ],
                
                [
                    'attribute'=>'salary',
                    'format' => 'decimal',
                    'contentOptions'=>['class'=>'text-right'],
                    'content'=> function($model) use ($modelAssign){
                        return $modelAssign->salary[$model->user_id];
                    },
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

     <?=$this->render('button',['event'=>$event]);?>
     
    <?php ActiveForm::end(); ?>

</div>

