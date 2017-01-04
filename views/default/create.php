<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPostionSalary */

$this->title = Yii::t('andahrm/position-salary', 'Create Person Postion Salary');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Postion Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-postion-salary-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelEdoc' => $modelEdoc,
    ]) ?>

</div>
