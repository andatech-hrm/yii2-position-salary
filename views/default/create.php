<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPositionSalary */

$this->title = Yii::t('andahrm/position-salary', 'Create Person Position Salary');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Position Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-position-salary-create">

    <?= $this->render('_form', [
        'model' => $model,
        //'modelEdoc'=> $modelEdoc
    ]) ?>

</div>
