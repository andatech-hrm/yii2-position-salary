<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;

use andahrm\leave\models\LeaveType;
use andahrm\structure\models\FiscalYear;
use yii\bootstrap\ActiveForm;
use backend\widgets\WizardMenu;
use andahrm\positionSalary\models\Assign;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */


$modelTopic = $event->sender->read('topic')[0];
$modelSelect = $event->sender->read('person')[0];
$status = $modelTopic->status;
//$modelSelect$modelSelect->leave_type_id;
//print_r($modelTopic->status);
$model->scenario = 'status'.$status;
// echo $model->scenario;
//echo '_formStatus'.$status;

// echo "<pre>";
//  print_r($model);
// exit();

$this->title = Yii::t('andahrm/position-salary', 'Assign').$modelTopic->statusLabel;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Position Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Create New'), 'url' => ['create','step'=>'reset']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo WizardMenu::widget([
      'currentStepCssClass' => 'selected',
      'step' => $event->step,
      'wizard' => $event->sender,
      'options' => ['class'=>'wizard_steps anchor']
    ]);?>

<div class="row">
    <div class="col-sm-12">
       
        <?php $form = ActiveForm::begin(); 
        echo $form->field($model,'status')->hiddenInput(['value'=>$modelTopic->status])->label(false);
        
        ?>
            <div class="x_panel tile">
            <div class="x_title">
                <h2><?= $this->title; ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <?php if($model->hasErrors()):?>
                    <!--<div class="alert alert-warning alert-dismissible fade in" role="alert">-->
                    <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>-->
                    <!--    </button>-->
                    <!--    <strong>คำเดือน</strong> พบข้อผิดพลาด-->
                    <!--</div>-->
                     <?= $form->errorSummary($model,['class'=>'alert alert-warning alert-dismissible fade in','role'=>'alert']); ?>
            <?php  endif;?>
              
             
             
             
             
               <?=$this->render('_formStatus'.$status,['event'=>$event,'form'=>$form,'modelAssign'=>$model]);?>
               
               <?=$this->render('button',['event'=>$event]);?>
              
               <div class="clearfix"></div>
               </div>
            </div>

    
        
         
        <?php ActiveForm::end(); ?>
    
    </div>
</div>

