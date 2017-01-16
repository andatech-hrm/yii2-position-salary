<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPostionSalary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-postion-salary-form">

    <?php $form = ActiveForm::begin(); ?>  
  
  <div class="row">
    <div class="col-sm-4">      
      <?= $form->field($modelEdoc, 'code')->textInput(['maxlength' => true]) ?>
    </div>
  </div>
  
  <div class="x_panel">
  <div class="x_title">
    <h2>รายละเอียดเอกสาร</h2>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="row">
      <div class="col-sm-8">
        <?= $form->field($modelEdoc, 'title')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-sm-4">
        <?php echo $form->field($modelEdoc, 'date_code')->widget(DatePicker::classname(), [              
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
        <?= $form->field($modelEdoc, 'file')->widget(FileInput::classname(), [
            'options' => ['accept' => 'pdf/*'],
            'pluginOptions' => [
              'previewFileType' => 'pdf',
              //'showPreview' => false,
              'showCaption' => false,
              'elCaptionText' => '#customCaption',
              'uploadUrl' => Url::to(['file-upload'])
            ]
        ]);?>
          <span id="customCaption" class="text-success">No file selected</span>
    </div>
  </div>
</div>
  <hr/>
  
  
  <div class="x_panel">
                  <div class="x_title">
                    <h2><?=Yii::t('andahrm', 'Person')?></h2>
                    <div class="nav navbar-right panel_toolbox">
                     <?= Html::button('<i class="fa fa-plus"></i> '.Yii::t('andahrm', 'Person'), [
                        'type' => 'button',
                        'title' => '<i class="fa fa-plus"></i> '.Yii::t('andahrm', 'Person'),
                        'class' => 'btn btn-success',
                        //'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");',
                        'data-toggle' => 'modal',
                        'data-target' => '#modal_add_person',
                    ]);
                    ?>
                       
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'adjust_date')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'step')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position_id')->textInput() ?>

    <?= $form->field($model, 'level')->textInput() ?>

    <?= $form->field($model, 'salary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edoc_id')->textInput() ?>
                    
                    
                      </div>
                </div>
                    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm/position-salary', 'Create') : Yii::t('andahrm/position-salary', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>




<!-- ----------------------------------------------------------------------------------- -->

<?php
### Avatar ##
Modal::begin([
    'id' => 'modal_add_person',
    'header' => '<h4 class="modal-title">เลือกบุคคล</h4>',
    'size' => Modal::SIZE_LARGE,
    'options' => [
        'class' => 'modal-change-photo',
    ]
]);
Pjax::begin(['id' => 'pjax_add_person', 'enablePushState' => false]);
echo "test";
// echo yii\grid\GridView::widget([
//     'dataProvider' => $person,
//     'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],
//             [
//             'label' => (new DevelopmentPerson)->getAttributeLabel('user_id'),
//             'value' => 'fullname'
//         ],
//             [
//             'label' => 'เลือก',
//             'content' => function($model) {
//                 $title = $model['selected'] ? '<i class="glyphicon glyphicon-remove"></i> ยกเลิก' : '<i class="glyphicon glyphicon-plus"></i> เลือก';
//                 $mode = $model['selected'] ? 'del' : 'add';
//                 $class = $model['selected'] ? 'btn btn-warning' : 'btn btn-success';
//                 $action = Yii::$app->controller->action->id;
//                 return Html::a($title, [$action, 'id' => $model['id'], 'mode' => $mode, 'user_id' => $model["user_id"]], ['class' => $class]);
//             }
//         ]
//     ]
// ]);
Pjax::end();
