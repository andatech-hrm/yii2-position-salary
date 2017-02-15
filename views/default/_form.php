<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use kartik\widgets\Typeahead

/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPostionSalary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-postion-salary-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>  
  
  <div class="row">
    <div class="col-sm-4">      
      <?php 
      $template = '<div class="block" style="border-bottom:1px;">'.
              '<div class="block_content">'.
              '<h2 class="title">{{code}}' .
              '<small class="pull-right">{{updated_at}}</small></h2>' .
              '<p class="excerpt">{{title}}</p>' .             
          '</div></div>';
      ?>
      <?= $form->field($model, 'code')->widget(Typeahead::classname(),[
              'options' => ['placeholder' => Yii::t('andahrm/position-salary', 'Please type number doc')],
              'pluginOptions' => ['highlight'=>true],
              'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                        'display' => 'value',
                        //'prefetch' => $baseUrl . '/samples/countries.json',
                        'remote' => [
                            'url' => Url::to(['/edoc/default/edoc-list']) . '?q=%QUERY',
                            'wildcard' => '%QUERY'
                        ],
                         'templates' => [
                            //'notFound' => '<div class="text-success" style="padding:0 8px">ไม่พบเอกสารนี้</div>',
                            'notFound' => false,
                            'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                        ]
                    ]
                ],
              'pluginEvents' => [
                  "typeahead:select" => 'function(ev, resp) { 
                      window.location = "'.Url::to(['assign-person']).'?edoc_id="+resp.id;
                      //console.log(resp);
                  }',
               ]
          ]) ?>
    </div>
  </div>
  
  <div class="x_panel">
  <div class="x_title">
    <h2>รายละเอียดเอกสาร</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <?= $form->field($model, 'id')->hiddenInput(['maxlength' => true])->label(false)->hint(false) ?>
    <div class="row">
      <div class="col-sm-8">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-sm-4">
        <?php echo $form->field($model, 'date_code')->widget(DatePicker::classname(), [              
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'daysOfWeekDisabled' => [0, 6],
                        'format' => 'yyyy-mm-dd',

                      //'startDate' => date('Y-m-d', strtotime("+3 day"))
                    ]
                ]);
                ?>
      </div>
    </div>
    
    <div class="well well-small">
        <?= $form->field($model, 'file')->widget(FileInput::classname(), [
            'options' => ['accept' => 'pdf/*'],
            'pluginOptions' => [
              //'previewFileType' => 'pdf',
              //'showPreview' => false,
              //'showCaption' => false,
              //'elCaptionText' => '#customCaption',
              'uploadUrl' => Url::to(['/edoc/default/file-upload'])
            ]
        ]);?>
          <span id="customCaption" class="text-success">No file selected</span>
    </div>
  </div>
</div>
  <hr/>
 
                    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm/position-salary', 'Assign person') , ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('andahrm/position-salary', 'Cencel') , ['index'],['class' => 'btn btn-link']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

