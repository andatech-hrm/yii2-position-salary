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
print_r($modelTopic->status);



?>

<?php
 
 
        echo yii\grid\GridView::widget([
            'dataProvider' => Assign::getPerson($modelSelect),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'user_id',
                    //'format'=>'html',
                    'value'=>'user.fullname',
                ],
                 [
                    'attribute'=>'step',
                    'content'=> function($model){
                        return $model->step
                        .Html::hiddenInput("Assign[current_step][{$model->user_id}]",
                            $model->step
                            );
                    },
                ],
                 [
                    'attribute'=>'adjust_date',
                    'content'=> function($model){
                        return Yii::$app->formatter->asDate($model->adjust_date)
                        .Html::hiddenInput("Assign[current_adjust_date][{$model->user_id}]",
                            $model->adjust_date
                            );
                    },
                    ],
                    
                  [
                    'attribute'=>'salary',
                    'format' => 'decimal',
                    'contentOptions'=>['class'=>'text-right'],
                    'content'=> function($model){
                        return Yii::$app->formatter->asDecimal($model->salary)
                        .Html::hiddenInput("Assign[current_salary][{$model->user_id}]",
                            $model->salary
                            );
                    },
                ],
                [
                    'attribute'=>'position_id',
                    'format'=>'html',
                    'content'=> function($model){
                        return $model->position->title."<br/><small>".$model->position->code."</small>"
                        .Html::hiddenInput("Assign[current_position_id][{$model->user_id}]",
                            $model->position_id
                            );
                    },
                ],
                
                
                
               
            ]
        ]);
        ?>