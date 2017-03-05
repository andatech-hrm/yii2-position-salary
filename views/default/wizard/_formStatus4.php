 <?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;

use andahrm\leave\models\LeaveType;
use andahrm\structure\models\FiscalYear;
use yii\bootstrap\ActiveForm;
use backend\widgets\WizardMenu;
use andahrm\positionSalary\models\Assign;
 
 $modelTopic = $event->sender->read('topic')[0];
$modelSelect = $event->sender->read('person')[0];
//$modelSelect$modelSelect->leave_type_id;



?>

<?php
 
 
        echo yii\grid\GridView::widget([
            'dataProvider' => Assign::getPerson($modelSelect),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                 [
                    'attribute'=>'user_id',
                    'format'=>'html',
                    //'value'=>'user.fullname',
                    'content'=> function($model) use ($form){
                        return $model->user->fullname
                        .$form->field($model,"user_id[{$model->user_id}]")->hiddenInput(['value'=>$model->user_id])->label(false);
                    },
                ],
                 [
                    'attribute'=>'level',
                    'content'=> function($model){
                        return $model->step
                        .Html::hiddenInput("Assign[level][{$model->user_id}]",
                            $model->level
                            );
                    },
                ],
                 
                    
                  [
                    'attribute'=>'salary',
                    'format' => 'decimal',
                    'contentOptions'=>['class'=>'text-right'],
                    'content'=> function($model){
                        return Yii::$app->formatter->asDecimal($model->salary)
                        .Html::hiddenInput("Assign[salary][{$model->user_id}]",
                            $model->salary
                            );
                    },
                ],
                [
                    'attribute'=>'position_id',
                    'format'=>'html',
                    'content'=> function($model){
                        return $model->positionTitleCode."</small>"
                        .Html::hiddenInput("Assign[position_id][{$model->user_id}]",
                            $model->position_id
                            );
                    },
                ],
                
                
                
               
            ]
        ]);
        ?>