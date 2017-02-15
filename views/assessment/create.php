<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\Assessment */

$this->title = Yii::t('andahrm/position-salary', 'Create Assessment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Assessments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assessment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
