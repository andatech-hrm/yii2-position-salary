<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use andahrm\positionSalary\models\PersonPosition;
use andahrm\structure\models\FiscalYear;


/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\Assessment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="assessment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(PersonPosition::getList(),[]) ?>

    <?php //echo $form->field($model, 'year')->dropDownList(FiscalYear::getList(),[]) ?>
    <?php echo $form->field($model, 'year')->widget(\kuakling\datepicker\YearBuddhist::className()) ?>

    <?= $form->field($model, 'phase')->dropDownList([1=>1,2=>2],[]) ?>

    <?= $form->field($model, 'assessment')->textInput() ?>

    <?= $form->field($model, 'percent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
