 <?php
use yii\helpers\Html;
use yii\grid\GridView;
//use yii\widgets\ActiveForm;

use andahrm\leave\models\LeaveType;
use andahrm\structure\models\Position;
use yii\bootstrap\ActiveForm;
use backend\widgets\WizardMenu;
use andahrm\positionSalary\models\Assign;
use kartik\widgets\Select2;
use andahrm\datepicker\DatePicker;
use andahrm\setting\models\Helper;

 
$modelTopic = $event->sender->read('topic')[0];
$modelSelect = $event->sender->read('person')[0];
//$modelSelect$modelSelect->leave_type_id;
//print_r($modelTopic->status);

//print_r(Assign::getRangeStep());

?>

<?php
 
 
        echo GridView::widget([
            'dataProvider' => Assign::getPerson($modelSelect),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'user_id',
                    'format'=>'html',
                    //'value'=>'user.fullname',
                    'content'=> function($model) use ($form){
                        return $model->user->fullname
                        .'<br/>'
                        .$model->positionTitleCode
                        .$form->field($model,"user_id[{$model->user_id}]")->hiddenInput(['value'=>$model->user_id])->label(false);
                    },
                ],
                [
                    'attribute'=>'position_id',
                    'headerOptions'=>['width'=>120],
                    'format'=>'html',
                    'content'=> function($model) use ($form,$modelAssign){
                        return 
                        $form->field($model, "new_position_id[{$model->user_id}]")
                                    ->widget(Select2::className(), [
                                        //'name' => 'dev_activity_char_id',
                                        //'value' => $model->new_position_id?$model->new_position_id:$model->position_id,
                                        'data' => Position::getListTitle(),
                                        'options' => [
                                            'placeholder' => Yii::t('andahrm','Select'), 
                                            'value' => $modelAssign->new_position_id[$model->user_id]?$modelAssign->new_position_id[$model->user_id]:$model->position_id,
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label(false)
                         .$form->field($model,"position_id[{$model->user_id}]")->hiddenInput(['value'=>$model->position_id])->label(false);
                    },
                ],
                
                // [
                //     'attribute'=>'level',
                //     'contentOptions'=>['class'=>'text-right'],
                //     'content'=> function($model) use ($form){
                //         return $model->level
                //         .$form->field($model,"level[{$model->user_id}]")->hiddenInput(['value'=>$model->level])->label(false);
                //     },
                // ],
                [
                    'attribute'=>'level',
                    'format'=>'html',
                    'headerOptions'=>['width'=>80],
                    'content'=> function($model) use ($form,$modelAssign){
                        return $form->field($model,"level[{$model->user_id}]")->textInput(['value'=> $modelAssign->level[$model->user_id]?$modelAssign->level[$model->user_id]:$model->level])->label(false);
                    },
                ],
                // [
                //     'attribute'=>'step',
                //     'contentOptions'=>['class'=>'text-right'],
                //     'content'=> function($model) use ($form){
                //         return $model->step
                //         .$form->field($model,"step[{$model->user_id}]")->hiddenInput(['value'=>$model->step])->label(false);
                //     },
                // ],
                // [
                //     'attribute'=>'step_adjust',
                //     'headerOptions'=>['width'=>80],
                //     'content'=> function($model) use ($form){
                //         return $form->field($model,"step_adjust[{$model->user_id}]")->dropDownList(Assign::getRangeStep(),['prompt'=>Yii::t('andahrm','Select')])->label(false);
                //     },
                // ],
                // [
                //     'attribute'=>'new_step',
                //     'headerOptions'=>['width'=>80],
                //     'content'=> function($model) use ($form){
                //         return $form->field($model,"new_step[{$model->user_id}]")->textInput(['value'=>$model->new_step?$model->new_step:$model->step])->label(false);
                //     },
                // ],
                // [
                //     'attribute'=>'salary',
                //     'contentOptions'=>['class'=>'text-right'],
                //     'content'=> function($model) use ($form){
                //         return $model->salary
                //         .$form->field($model,"salary[{$model->user_id}]")->hiddenInput(['value'=>$model->salary])->label(false);
                //     },
                // ],
                [
                    'attribute'=>'salary',
                    'headerOptions'=>['width'=>120],
                    'contentOptions'=>['class'=>'text-right'],
                    'content'=> function($model) use ($form){
                        return $form->field($model,"salary[{$model->user_id}]")->textInput(['value'=>$model->salary])->label(false);
                    },
                ],
                [
                    'attribute'=>'start_date',
                     'headerOptions'=>['width'=>130],
                    'contentOptions'=>['class'=>'text-right'],
                    'content'=> function($model) use ($form,$modelAssign){
                        $model->start_date = Helper::dateUi2Db($modelAssign->start_date[$model->user_id]);
                        return  $form->field($model, "start_date[{$model->user_id}]")->label(false)->widget(DatePicker::className(),['options'=>['value'=>$model->start_date]]);
                    },
                ],
                [
                    'attribute'=>'end_date',
                     'headerOptions'=>['width'=>130],
                    'contentOptions'=>['class'=>'text-right'],
                    'content'=> function($model) use ($form,$modelAssign){
                        // $model->end_date = $modelAssign->end_date[$model->user_id];
                        $model->end_date = Helper::dateUi2Db($modelAssign->end_date[$model->user_id]);
                        return $form->field($model, "end_date[{$model->user_id}]")->label(false)->widget(DatePicker::className());
                    },
                ],
                 
                //  [
                //     'attribute'=>'adjust_date',
                //     'content'=> function($model){
                //         return Yii::$app->formatter->asDate($model->adjust_date)
                //         .Html::hiddenInput("Assign[current_adjust_date][{$model->user_id}]",
                //             $model->adjust_date
                //             );
                //     },
                //     ],
                    
                  
                
                
                
                
               
            ]
        ]);
        ?>