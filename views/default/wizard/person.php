<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use backend\widgets\WizardMenu;
use andahrm\positionSalary\models\Person;
use andahrm\structure\models\PersonType;
use andahrm\structure\models\BaseSalary;
use andahrm\structure\models\PositionLine;
use andahrm\structure\models\Section;
use andahrm\structure\models\FiscalYear;
use kartik\widgets\DepDrop;


use yii\widgets\Pjax;

$modelTopic = $event->sender->read('topic')[0];
//print_r($person);
 
//print_r($event);
//echo "</pre>";
//echo $ss->insignia_type_id;


// echo "<pre>";
// print_r($event);
// echo "</pre>";

$this->title = Yii::t('andahrm/position-salary', 'Select Person');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Position Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Create New'), 'url' => ['create','step'=>'reset']];
$this->params['breadcrumbs'][] = $this->title;

// echo "555";
// print_r($model->selection);
// echo "6555";
?>

<?php echo WizardMenu::widget([
      'currentStepCssClass' => 'selected',
      'step' => $event->step,
      'wizard' => $event->sender,
      'options' => ['class'=>'wizard_steps anchor']
    ]);?>




<div class="x_panel tile">
    <div class="x_title">
        <h2><?= Yii::t('andahrm/position-salary', 'Select Person'); ?></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        
        <?php $form = ActiveForm::begin(); ?>
        
         <?php if($model->hasErrors()):
         echo $form->errorSummary($model,['class'=>'alert alert-warning alert-dismissible fade in','role'=>'alert']); 
           endif;?>
        
        <div class="row">
        
      
      
      <div class="col-sm-4">
        <?= $form->field($model, 'person_type_id')->dropDownList(PersonType::getList(false,$modelTopic->person_type_id),[
          'prompt'=>Yii::t('app','Select'),
          //'id'=>'ddl-person_type',
        ]) ?>
      </div>
      
      <div class="col-sm-4">
        <?= $form->field($model, 'section_id')->dropDownList(Section::getList(),['prompt'=>Yii::t('app','Select')]) ?>
      </div>
      

      <div class="col-sm-4">
        <?= $form->field($model, 'position_line_id')->widget(DepDrop::classname(), [
            'options'=>[
                'prompt'=>Yii::t('app','Select'),
            ],
            
            'data'=> PositionLine::getListByPersonType($model->person_type_id,$model->section_id),
            'pluginOptions'=>[
                'depends'=>['person-section_id', 'person-person_type_id'],
                'placeholder'=>Yii::t('app','Select'),
                'url'=>Url::to(['get-position-line'])
            ]
        ]); ?>
      </div>
      </div>
      
      
      
      <div class="row">
        
      <div class="col-sm-12 grid-view-area">
      
           <?php #echo Yii::$app->runAction("/position-salary/default/bind-person");?>
       </div>
      </div>
    
     <?=$this->render('button',['event'=>$event]);?>
     
     <?php ActiveForm::end(); ?>

        <div class="clearfix"></div>
    </div>
</div>


<?php
$js =[];
$urlPerson = Url::to(['bind-person']);
$selection = json_encode($model->selection);
$js[] = <<< Js
    
    $(function(){
        var selection='{$selection}';
        var section_id=$('#person-section_id option:selected').val();
        var person_type_id=$('#person-person_type_id option:selected').val();
        var position_line_id=$('#person-position_line_id option:selected').val();
        
        //bindPerson(selection,section_id,person_type_id,position_line_id);
        
        $('#person-section_id').change(function(){
            section_id = $(this).find('option:selected').val();
            bindPerson(selection,section_id,person_type_id,position_line_id);
            console.log('person-section_id');
        });
        
        $('#person-person_type_id').change(function(){
            person_type_id = $(this).find('option:selected').val();
            bindPerson(selection,section_id,person_type_id,position_line_id);
            console.log('person-person_type_id');
        });
        
         $('#person-position_line_id').change(function(){
            position_line_id = $(this).find('option:selected').val();
            bindPerson(selection,section_id,person_type_id,position_line_id);
            console.log('person-position_line_id');
        });
        
        
    });
    

Js;
$js[] = <<< Js
    function bindPerson(selection,section_id,person_type_id,position_line_id){
        $.get("{$urlPerson}",{
            selection:selection,
            section_id:section_id,
            person_type_id:person_type_id,
            position_line_id:position_line_id,
        },function(data){
            console.log(data);
            $('.grid-view-area').html(data);
        });
    }
Js;

$this->registerJs(implode("\n",$js));


