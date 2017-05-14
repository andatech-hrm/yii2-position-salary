<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use kartik\widgets\Typeahead;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\helpers\Json;
use backend\widgets\WizardMenu;

use kuakling\datepicker\DatePicker;
use andahrm\setting\models\WidgetSettings;
use andahrm\positionSalary\models\Topic;
use andahrm\edoc\models\Edoc;
use andahrm\structure\models\PersonType;

$modelTopic = isset($event->sender->read('topic')[0])?$event->sender->read('topic')[0]:null;
// echo "<pre>";
// print_r($modelTopic->person_type_id);
// exit();

$this->title = Yii::t('andahrm/position-salary', 'Topic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Position Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Create New'), 'url' => ['create','step'=>'reset']];
$this->params['breadcrumbs'][] = $this->title;


$modals['edoc'] = Modal::begin([
    'header' => Yii::t('andahrm/person', 'Edoc'),
    'size' => Modal::SIZE_LARGE
]);
// echo $this->render('@andahrm/edoc/views/default/_form', ['model' => new \andahrm\edoc\models\Edoc(), ]);
echo Yii::$app->runAction('/edoc/default/create-ajax', ['formAction' => Url::to(['/edoc/default/create-ajax'])]);
// echo '<iframe src="" frameborder="0" style="width:100%; height: 100%;" id="iframe_edoc_create"></iframe>';
            
Modal::end();
?>

<?php echo WizardMenu::widget([
      'currentStepCssClass' => 'selected',
      'step' => $event->step,
      'wizard' => $event->sender,
      'options' => ['class'=>'wizard_steps anchor']
    ]);?>


        <?php $form = ActiveForm::begin([
            'options'=>['data-pjax' => ''],
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{endWrapper}{error}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-2',
                    'offset' => 'col-sm-offset-2',
                    'wrapper' => 'col-sm-4',
                    'error' => 'col-sm-4',
                    'hint' => '',
                ],
            ],
        ]); ?>
        
<div class="x_panel tile">
    <div class="x_title">
        <h2><?= $this->title; ?></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

11
        <?php #echo $form->errorSummary($model); ?>
22
         <?php echo $form->field($model,'title',[
            'horizontalCssClasses' => [
                    'wrapper' => 'col-sm-6',
                ]
        ])->textInput();?>
 

        <?php echo $form->field($model,'adjust_date')->widget(DatePicker::classname(), [              
          'options' => [
            'daysOfWeekDisabled' => [0, 6],
          ]
        ]);?>

 
 

        <?php echo $form->field($model,'person_type_id')->radioList(PersonType::getParentList(false))?>
        
        
        <div class="status" style="display:none;">
           
            <?php 
            
            foreach( PersonType::getParentList(false) as $idStatus => $titleStatus ){
                //$getItem = 'getItemStatus'.$idStatus;
                echo $form->field( $model, "select_status[{$idStatus}]" )->radioList(Topic::getItemStatusGroup($idStatus),['id'=>'select_status'.$idStatus]);
            }
            ?>
            
             
         <?=$form->field($model, "status",[
            'horizontalCssClasses' => [
                    'label' => 'col-sm-2',
                    'offset' => 'col-sm-offset-2',
                    'wrapper' => false,
                    'error' => 'col-sm-4 col-sm-offset-2',
                    'hint' => '',
                ],
        ])->hiddenInput()->label(false);?>   
        </div>
        
 
<hr/>


<div class="row">
        
<?php
$edocInputTemplate = <<< HTML
<div class="input-group">
    {input}
    <span class="input-group-addon btn btn-success"  role="edoc" data-toggle="modal" data-target="#{$modals['edoc']->id}">
        <i class="fa fa-plus"></i>
    </span>
</div>
HTML;
echo $form->field($model, "edoc_id", [
        'inputTemplate' => $edocInputTemplate,
        // 'options' => [
        //     'class' => 'form-group col-sm-6'
        // ]
    ])->widget(Select2::className(), WidgetSettings::Select2(['data' => Edoc::getList()]));
?>
            
</div>



         <?=$this->render('button',['event'=>$event]);?>

        <div class="clearfix"></div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$edocInputId = Html::getInputId($model, 'edoc_id');
$jsHead[] = <<< JS
function callbackEdoc(result)
{   
    $("#{$edocInputId}").append($('<option>', {
        value: result.id,
        text: result.code + ' - ' + result.title
    }));
    $("#{$edocInputId}").val(result.id).trigger('change.select2');
    
    $("#{$modals['edoc']->id}").modal('hide');
    
    
}
JS;
$this->registerJs(implode("\n", $jsHead), $this::POS_HEAD);
$person_type_id = isset($modelTopic->person_type_id)?$modelTopic->person_type_id:null;

$js[] = <<< JS
//On load
  var className = 'required';
  //$(".status .form-group ").removeClass(className);
  $(".status .form-group:not(.field-topic-status)").hide();
  $(".status .form-group  input[name='Topic[select_status]'] ").attr('disabled',true);
  var id = "{$person_type_id}";
  if(id){
     $(".field-select_status"+id).fadeIn(500);
    $(".field-select_status"+id+" input[name='Topic[select_status]']").attr('disabled',false);
  }
  $(".status").show();
  
  //When select Person type
      $("input[name='Topic[person_type_id]']").on('change',function(){
          var id = $(this).val();
          
          ///$(".status .form-group ").removeClass(className);
          $(".status .form-group:not(.field-topic-status)").hide();
          $(".status .form-group input[name='Topic[select_status]'] ").attr('disabled',true);
          
          
          //$(".field-status"+id).addClass(className);
          $(".field-select_status"+id).fadeIn(500);
          $(".field-select_status"+id+" input[name='Topic[select_status]']").attr('disabled',false);
          bineToStatus(id);
      });
      
//Add event radio
function bineToStatus(id){
     $("input[type='radio'][name='Topic[select_status]["+id+"]']").each(function(index){
         //alert($(this).selector);
         $(this).on('change',function(){
             //alert($(this).val()); 
             $("input[name='Topic[status]']").val($(this).val());
              $(".status .form-group.field-topic-status").removeClass("has-error");
              $(".status .form-group.field-topic-status .help-block-error").hide();
         });
        
     });
}

JS;


$this->registerJs(implode("\n", $js));
?>