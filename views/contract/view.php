<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\positionSalary\models\PersonContract */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Contracts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-contract-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm/position-salary', 'Update'), ['update', 'user_id' => $model->user_id, 'position_id' => $model->position_id, 'edoc_id' => $model->edoc_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('andahrm/position-salary', 'Delete'), ['delete', 'user_id' => $model->user_id, 'position_id' => $model->position_id, 'edoc_id' => $model->edoc_id], [
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
            'position_id',
            'edoc_id',
            'start_date',
            'end_date',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
