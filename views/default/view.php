<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\widgets\DetailView;
use yii\grid\GridView;

use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;

use andahrm\positionSalary\models\PersonPositionSalary;
use andahrm\person\models\Person;
use andahrm\structure\models\Position;

/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPostionSalary */
/* @var $form yii\widgets\ActiveForm */

$this->title = $modelEdoc->code.' '.$modelEdoc->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Position Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;



$context = $this->context->action;
$action = Yii::$app->controller->action->id;
?>

<div class="person-postion-salary-form">
  <?= DetailView::widget([
        'model' => $modelEdoc,
        'attributes' => [
            'code',
            'title',
            'date_code:date',            
            //'file',
//             [
//               'attribute'=>'file',
//               'format'=>'raw',
//               'value'=>Html::button($modelEdoc->file, [
//                     'class' => 'btn btn-link',
//                     'data-toggle' => 'modal',
//                     'data-target' => '#paper-modal',
//                     ])
//             ]
        ],
    ]) ?>
  
  
  <?php
echo \yii2assets\pdfjs\PdfJs::widget([
  'url' => Url::base().'/..'.$modelEdoc->getUploadUrl('file'),
  'buttons'=>[
    'presentationMode' => false,
    'openFile' => false,
    'print' => true,
    'download' => true,
    'viewBookmark' => false,
    'secondaryToolbarToggle' => false,
    'fullscreen'=>true,
  ]
]);
   ?>

  
   
  <hr/>
  <?php
  /*
  Modal::begin([
    'id'=> 'paper-modal',
    'header' => '<h2>ไฟล์แนบ</h2>',
    'size'=> Modal::SIZE_LARGE,
]);

echo \yii2assets\pdfjs\PdfJs::widget([
  'url' => Url::base().'/..'.$modelEdoc->getUploadUrl('file')
]);

Modal::end();
*/
  ?>
  
 
  
  
  <div class="x_panel">
                  <div class="x_title">
                    <h2><?=Yii::t('andahrm', 'Person')?></h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'adjust_date:date',
            [
              'attribute'=>'user_id',
              'value'=>'user.fullname'
            ],
            [
              'attribute'=>'position_id',
              'value'=>'position.code'
            ],            
            'title',
            // 'status',
             //'step',
             'level',
             'salary',
  ]
    ]); ?>

    
                      </div>
                </div>
                    

   


</div>




