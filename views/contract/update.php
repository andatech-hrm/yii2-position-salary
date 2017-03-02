<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonContract */

$this->title = Yii::t('andahrm/position-salary', 'Update {modelClass}: ', [
    'modelClass' => 'Person Contract',
]) . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Contracts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'user_id' => $model->user_id, 'position_id' => $model->position_id, 'edoc_id' => $model->edoc_id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/position-salary', 'Update');
?>
<div class="person-contract-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
