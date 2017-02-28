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



//print_r($person);
 
//print_r($event);
//echo "</pre>";
//echo $ss->insignia_type_id;


// echo "<pre>";
// print_r($event);
// echo "</pre>";

$this->title = Yii::t('andahrm/position-salary', 'Select Person');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Position Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Create New'), 'url' => ['create','step'=>'reset']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo WizardMenu::widget([
      'currentStepCssClass' => 'selected',
      'step' => $event->step,
      'wizard' => $event->sender,
      'options' => ['class'=>'wizard_steps anchor']
    ]);?>


<?php $form = ActiveForm::begin(); ?>

<div class="x_panel tile">
    <div class="x_title">
        <h2><?= Yii::t('andahrm/position-salary', 'Select Person'); ?></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        
        
        <div class="row">
        
      <div class="col-sm-4">
        <?= $form->field($model, 'section_id')->dropDownList(Section::getList(),['prompt'=>Yii::t('app','Select')]) ?>
      </div>
      
      <div class="col-sm-4">
        <?= $form->field($model, 'person_type_id')->dropDownList(PersonType::getList(),[
          'prompt'=>Yii::t('app','Select'),
          'id'=>'ddl-person_type',
        ]) ?>
      </div>
      

      <div class="col-sm-4">
        <?= $form->field($model, 'position_line_id')->widget(DepDrop::classname(), [
            'options'=>['id'=>'ddl-position_type'],
            'data'=> PositionLine::getListByPersonType($model->person_type_id),
            'pluginOptions'=>[
                'depends'=>['ddl-person_type'],
                'placeholder'=>Yii::t('app','Select'),
                'url'=>Url::to(['get-position-line'])
            ]
        ]); ?>
      </div>
      </div>
        
        <?php
        $selection = $model; #Global
        echo yii\grid\GridView::widget([
            'dataProvider' => Person::getPerson($event),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'name' => 'Person[selection][]',
                    'checkboxOptions' => function ($model, $key, $index, $column) use ($selection) {
                        $checked =  $selection->selection&&in_array($model->user_id,$selection->selection)?'checked':null;
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
    
        
     <?=$this->render('button',['event'=>$event]);?>
     
     

        <div class="clearfix"></div>
    </div>
</div>
<?php ActiveForm::end(); ?>