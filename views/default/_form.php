<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPostionSalary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-postion-salary-form">

    <?php $form = ActiveForm::begin(); ?>
  
    <?= $form->field($modelEdoc, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelEdoc, 'date_code')->textInput() ?>

    <?= $form->field($modelEdoc, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelEdoc, 'file')->textInput(['maxlength' => true]) ?>
  
  <hr/>
  
  
  

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'adjust_date')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'step')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position_id')->textInput() ?>

    <?= $form->field($model, 'level')->textInput() ?>

    <?= $form->field($model, 'salary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edoc_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm/position-salary', 'Create') : Yii::t('andahrm/position-salary', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
