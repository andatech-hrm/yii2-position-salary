<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonContract */

$this->title = Yii::t('andahrm/position-salary', 'Create Person Contract');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Contracts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-contract-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
