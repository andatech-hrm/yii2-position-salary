<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonPositionSalary */

$this->title = Yii::t('andahrm', 'Update {modelClass}: ', [
    'modelClass' => 'Person Position Salary',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Position Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'user_id' => $model->user_id, 'position_id' => $model->position_id, 'edoc_id' => $model->edoc_id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
?>
<div class="person-position-salary-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
