<?php
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<?php
$request = Yii::$app->request;
$profile = Yii::$app->user->identity->profile;
$module = $this->context->module->id;
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel tile">
            <div class="x_title">
                <h2><?= $this->title; ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php echo $content; ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
