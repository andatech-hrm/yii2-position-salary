<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPostionSalary */

$this->title = Yii::t('andahrm/position-salary', 'Update {modelClass}: ', [
    'modelClass' => 'Person Postion Salary',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Postion Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'user_id' => $model->user_id, 'position_id' => $model->position_id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/position-salary', 'Update');
?>
<div class="person-postion-salary-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
