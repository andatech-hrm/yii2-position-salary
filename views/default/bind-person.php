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


?>

        <?php
        //$selection = $model; #Global
        Pjax::begin();
        echo yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                // [
                //     'class' => 'yii\grid\CheckboxColumn',
                //     'name' => 'Person[selection][]',
                //     'checkboxOptions' => function ($model, $key, $index, $column) use ($selection) {
                //         $checked=null;
                //         $checked =  $selection&&in_array($model->user_id,$selection)?'checked':null;
                //         return [
                //             'id'=>'checkbox'.$model->user_id,
                //             'value' => $model->user_id,
                //             'checked' => $checked,
                //         ];
                //      }
                // ],
                [
                    'attribute'=>'user_id',
                    'format'=>'raw',
                    'value'=>function($model){
                        return Html::label($model->user->fullname,'checkbox'.$model->user_id);
                    }
                ],
                  [
                    'attribute'=>'position_id',
                    'format'=>'html',
                    'value'=> function($model){
                        return $model->position->title."<br/><small>".$model->position->code."</small>";
                    }
                ],
                //  [
                //     'attribute'=>'adjust_date',
                //     'format' => 'date'
                // ],
                [
                    'attribute'=>'level',
                    //'value'=> 'position.title',
                ],
                
                [
                    'attribute'=>'salary',
                    'format' => 'decimal',
                    'contentOptions'=>['class'=>'text-right']
                ],
              
                [
                    'attribute'=>'edoc_id',
                    'format'=>'html',
                    'value'=> 'edoc.codeTitle'
                ],
                [
                    'content' => function($model){
                        return Html::a('Add',[
                            'bind-person','mode'=>'add','user_id'=>$model->user_id
                            ],['class'=>'btn btn-success btn-add']);        
                    }
                ]
            ]
        ]);
        
        
        echo yii\grid\GridView::widget([
            'dataProvider' => $dataSelectedProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                // [
                //     'class' => 'yii\grid\CheckboxColumn',
                //     'name' => 'Person[selection][]',
                //     'checkboxOptions' => function ($model, $key, $index, $column) use ($selection) {
                //         $checked=null;
                //         $checked =  $selection&&in_array($model->user_id,$selection)?'checked':null;
                //         return [
                //             'id'=>'checkbox'.$model->user_id,
                //             'value' => $model->user_id,
                //             'checked' => $checked,
                //         ];
                //      }
                // ],
                [
                    'attribute'=>'user_id',
                    'format'=>'raw',
                    'value'=>function($model){
                        return Html::label($model->user->fullname,'checkbox'.$model->user_id);
                    }
                ],
                  [
                    'attribute'=>'position_id',
                    'format'=>'html',
                    'value'=> function($model){
                        return $model->position->title."<br/><small>".$model->position->code."</small>";
                    }
                ],
                //  [
                //     'attribute'=>'adjust_date',
                //     'format' => 'date'
                // ],
                [
                    'attribute'=>'level',
                    //'value'=> 'position.title',
                ],
                
                [
                    'attribute'=>'salary',
                    'format' => 'decimal',
                    'contentOptions'=>['class'=>'text-right']
                ],
              
                [
                    'attribute'=>'edoc_id',
                    'format'=>'html',
                    'value'=> 'edoc.codeTitle'
                ],
                [
                    'content' => function($model){
                        return Html::a('Remove',[
                            'bind-person','mode'=>'del','user_id'=>$model->user_id
                            ],['class'=>'btn btn-warning btn-del'])
                        .Html::textInput('Person[selection][]',$model->user_id);        
                    }
                ]
            ]
        ]);
        Pjax::begin();
        ?>
        
<?php

$js = [];
$js[] = <<< JS




JS;
    
    
        