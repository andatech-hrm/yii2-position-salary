<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\Assessment */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Assessments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assessment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm/position-salary', 'Update'), ['update', 'user_id' => $model->user_id, 'year' => $model->year, 'phase' => $model->phase], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('andahrm/position-salary', 'Delete'), ['delete', 'user_id' => $model->user_id, 'year' => $model->year, 'phase' => $model->phase], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('andahrm/position-salary', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_id',
            'year',
            'phase',
            'assessment',
            'percent',
            'level',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at',
        ],
    ]) ?>

</div>
