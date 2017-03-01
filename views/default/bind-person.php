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
        echo yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'name' => 'Person[selection][]',
                    'checkboxOptions' => function ($model, $key, $index, $column) use ($selection) {
                        $checked=null;
                        $checked =  $selection&&in_array($model->user_id,$selection)?'checked':null;
                        return [
                            'value' => $model->user_id,
                            'checked' => $checked,
                        ];
                     }
                ],
                [
                    'attribute'=>'user_id',
                    'value'=>'user.fullname',
                ],
                
                
                [
                    'attribute'=>'step',
                    //'value'=> 'position.title',
                ],
                 [
                    'attribute'=>'adjust_date',
                    'format' => 'date'
                ],
                [
                    'attribute'=>'salary',
                    'format' => 'decimal',
                    'contentOptions'=>['class'=>'text-right']
                ],
                [
                    'attribute'=>'position_id',
                    'format'=>'html',
                    'value'=> function($model){
                        return $model->position->title."<br/><small>".$model->position->code."</small>";
                    }
                ],
                [
                    'attribute'=>'edoc_id',
                    'format'=>'html',
                    'value'=> 'edoc.codeTitle'
                ],
            ]
        ]);
        ?>
    
    
        