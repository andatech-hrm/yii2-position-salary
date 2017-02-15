<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\widgets\DetailView;

use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;

use andahrm\positionSalary\models\PersonPositionSalary;
use andahrm\positionSalary\models\PersonPosition;
use andahrm\structure\models\Position;

/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPostionSalary */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('andahrm/position-salary', 'Assign Person Position Salary');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Update'), 'url' => ['update-edoc','edoc_id'=>$edoc_id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $this->title;

$context = $this->context->action;
$action = Yii::$app->controller->action->id;
?>

<div class="person-postion-salary-form">

   

  
   <?= DetailView::widget([
        'model' => $modelEdoc,
        'attributes' => [
            'code',
            'date_code:date',
            'title',
            //'file',
            [
              'attribute'=>'file',
              'format'=>'raw',
              'value'=>Html::button($modelEdoc->file, [
                    'class' => 'btn btn-link',
                    'data-toggle' => 'modal',
                    'data-target' => '#paper-modal',
                    ])
            ]
        ],
    ]) ?>
  <hr/>
  <?php
  Modal::begin([
    'id'=> 'paper-modal',
    'header' => '<h2>ไฟล์แนบ</h2>',
    'size'=> Modal::SIZE_LARGE,
]);

echo \yii2assets\pdfjs\PdfJs::widget([
  'url' => Url::base().'/..'.$modelEdoc->getUploadUrl('file')
]);

Modal::end();
  ?>
  
   <?php $form = ActiveForm::begin(); ?>  
  
  
  <div class="x_panel">
                  <div class="x_title">
                    <h2><?=Yii::t('andahrm', 'Person')?></h2>
                    <div class="nav navbar-right panel_toolbox">
                     <?= Html::button('<i class="fa fa-plus"></i> '.Yii::t('andahrm/position-salary', 'Assign person'), [
                        'type' => 'button',
                        'title' => '<i class="fa fa-plus"></i> '.Yii::t('andahrm/position-salary', 'Assign person'),
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
                    
                

    <?php Pjax::begin(['id' => 'pjax_grid_person', 'enablePushState' => false]);
            ?>
            
            <?php
            $session = Yii::$app->session;
            
            // echo "<pre>";
            // print_r($session['person_position']);
            // echo "</pre>";
            
            $PersonPositionSalary = new PersonPositionSalary();
            ?>
            <div class="raw">
                <div class="col-md-3 col-md-push-9">
                    <?= $form->field($PersonPositionSalary,  "status")->dropdownList(PersonPositionSalary::getItemStatus(),[
                'prompt'=>'เลือกสถานะ']);?>
                </div>
            </div>
            
            
            <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap">
                <thead>
                    <tr>
                        <th><?= Html::label("#") ?></th>                        
                        <th width="220"><?= Html::activeLabel($PersonPositionSalary, 'user_id') ?></th>
                        <th width="180" nowrap=""><?= Html::activeLabel($PersonPositionSalary, 'position_id') ?></th>
                        <th nowrap=""><?= Html::activeLabel($PersonPositionSalary, 'level') ?></th>
                        <th nowrap=""><?= Html::activeLabel($PersonPositionSalary, 'salary') ?></th>
                        <th><?= Html::label("ลบ") ?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                   
                    $index = 0;
                    if ($session->has('person_position') && !empty($session['person_position'][$modelEdoc->id])){
                        foreach ($session['person_position'][$modelEdoc->id] as $key => $sessionPerson):
                            $modelDevPerson = new PersonPositionSalary();
                            $sessionPerson = (object) $sessionPerson;
                            
                            $modelPerson = PersonPosition::findOne($sessionPerson->user_id);
                            //print_r($modelPerson);
                            //exit();
//                        echo $modelPerson->char;
//                    echo "<br/>";
                            $modelDevPerson->edoc_id = $modelEdoc->id;
                            $modelDevPerson->user_id = $sessionPerson->user_id;
                            $modelDevPerson->position_id = $sessionPerson->position_id;
                            $modelDevPerson->level = $sessionPerson->level;
                            $modelDevPerson->salary = $sessionPerson->salary;
                            ?>            
                            <tr>
                                <td><?= ( ++$index) ?>
                                <?= $form->field($modelDevPerson,  "[{$key}]edoc_id")->hiddenInput()->label(false)->hint(false) ?>
                                <?= $form->field($modelDevPerson, "[{$key}]user_id")->hiddenInput()->hint(false)->label(false) ?>
                                </td>
                                
                                <td >
                                  
                                    <?= $sessionPerson->fullname ?>
                                    
                                </td>
                                <td>      
                                    <?=$modelPerson->positionTitle?>
                                    <?=
                                    $form->field($modelDevPerson, "[{$key}]position_id", ['showLabels' => false])
                                    ->widget(Select2::className(), [
                                        //'name' => 'dev_activity_char_id',
                                        'value' => $modelDevPerson->position_id,
                                        'data' => Position::getListTitle(),
                                        'options' => [
                                        'placeholder' => 'เลือก..', 
                                      //'multiple' => true
                                    ],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>

                                </td>
                              <td>
                                  <?=$modelPerson->positionSalary->level?>
                                 <?= $form->field($modelDevPerson, "[{$key}]level")->textInput(['value'=>$modelPerson->positionSalary->level])->hint(false)->label(false) ?>
                              </td>
                              <td>
                                  <?=$modelPerson->positionSalary->salary?>
                                 <?= $form->field($modelDevPerson, "[{$key}]salary")->textInput()->hint(false)->label(false) ?>
                              </td>
                              
                              <td>
                                  <?=$modelPerson->positionSalary->step?>
                                 <?= $form->field($modelDevPerson, "[{$key}]step")->textInput()->hint(false)->label(false) ?>
                              </td>
                                
                               
                                <td><?= Html::a('<i class="glyphicon glyphicon-remove"></i>', [$action, 'edoc_id' => $modelEdoc->id, 'mode' => 'del', 'user_id' => $sessionPerson->user_id], ['class' => 'btn_del btn btn-xs btn-danger']); ?></td>
                            </tr>
                            <?php
                        endforeach;
                    }
                    ?>

                </tbody>
            </table>
                    
                    <?php Pjax::end(); ?>
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
//echo "test";
echo yii\grid\GridView::widget([
    'dataProvider' => $person,
    'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => (new PersonPosition)->getAttributeLabel('user_id'),
                'value' => 'fullname',
                'format'=>'html'
            ],
            [
            'label' => 'เลือก',
            'content' => function($model) {
                $title = $model['selected'] ? '<i class="glyphicon glyphicon-remove"></i> ยกเลิก' : '<i class="glyphicon glyphicon-plus"></i> เลือก';
                $mode = $model['selected'] ? 'del' : 'add';
                $class = $model['selected'] ? 'btn btn-warning' : 'btn btn-success';
                $action = Yii::$app->controller->action->id;
                return Html::a($title, [$action,'edoc_id'=>$model["edoc_id"], 'mode' => $mode, 'user_id' => $model["user_id"]], ['class' => 'btn_add '.$class]);
            }
        ]
    ]
]);
Pjax::end();
Modal::end();

# JS
$js = [];
$js[] = '    
    // when add Person
   
      $("#pjax_add_person").on("pjax:end", function() {
          $.pjax.reload({container:"#pjax_grid_person"});  //Reload GridView    
      });  
      
    //   $(document).on("click",".btn_del",function(){
    //       alert(555);
    //       $.pjax.reload({container:"#pjax_add_person"});  //Reload GridView
    //   });
 
  
 ';
$js = array_filter($js);
$this->registerJs(implode("\n", $js), $this::POS_READY);
