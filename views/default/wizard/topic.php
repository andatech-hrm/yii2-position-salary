<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

use backend\widgets\WizardMenu;


use kartik\widgets\Typeahead;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use andahrm\setting\models\WidgetSettings;

use andahrm\positionSalary\models\Topic;
use andahrm\edoc\models\Edoc;
use yii\helpers\Json;

use kuakling\datepicker\DatePicker;


$this->title = Yii::t('andahrm/position-salary', 'Topic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Position Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Create New'), 'url' => ['create','step'=>'reset']];
$this->params['breadcrumbs'][] = $this->title;


$modals['edoc'] = Modal::begin([
    'header' => Yii::t('andahrm/person', 'Edoc'),
    'size' => Modal::SIZE_LARGE
]);
// echo $this->render('@andahrm/edoc/views/default/_form', ['model' => new \andahrm\edoc\models\Edoc(), ]);
//echo Yii::$app->runAction('/edoc/default/create-ajax', ['formAction' => Url::to(['/edoc/default/create-ajax'])]);
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

 
 

        <?php echo $form->field($model,'status')->radioList(Topic::getItemStatus())?>
 
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
?>