<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\Assessment */

$this->title = Yii::t('andahrm/position-salary', 'Update {modelClass}: ', [
    'modelClass' => 'Assessment',
]) . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Assessments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'user_id' => $model->user_id, 'year' => $model->year, 'phase' => $model->phase]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/position-salary', 'Update');
?>
<div class="assessment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
