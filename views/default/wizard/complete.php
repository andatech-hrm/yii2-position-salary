<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title =Yii::t('andahrm','Successful');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Person Position Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Create New'), 'url' => ['create','step'=>'reset']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="text-center">
    
    
    <br/>
    <br/>
    <br/>
    <div style="width:80px;height:80px;font-size:50px;display:inline-block;color:#3c763d;border:2px solid #3c763d;border-radius:50px;padding:3px;">
    <i class="fa fa-check"></i>
    </div>
    <?= Html::tag('h1', Yii::t('andahrm','Successful'),['class'=>'text-success']);?>
    <br/>
    <?=Html::a('OK',['index'],['class'=>'btn btn-success']);?>
    
    <br/>
    <br/>
    <br/>

</div>