<?php
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use mdm\admin\components\Helper;



$this->beginContent('@app/views/layouts/main.php'); 


$request = Yii::$app->request;
$profile = Yii::$app->user->identity->profile;
$module = $this->context->module->id;

?>


<div class="row hidden-print">
    <div class="col-md-12"> 
      
      <?php
    $menuItems = [];
    $menuItems[] =  [
           'label' => Yii::t('andahrm/position-salary', 'Person Position Salaries'),
            'url' => ["/{$module}/default/"],
            'icon' => 'fa fa-sitemap',
     ];
     
     $menuItems[] =  [
            'label' => Yii::t('andahrm/position-salary',  'Person Contracts'),
            'url' => ["/{$module}/contract/"],
            'icon' => 'fa fa-sitemap',
     ];

    $menuItems[] =  [
            'label' => Yii::t('andahrm/position-salary',  'Assessments'),
            'url' => ["/{$module}/assessment/"],
            'icon' => 'fa fa-sitemap',
     ];
     
    $menuItems = Helper::filter($menuItems);
    $newMenu = [];
    foreach($menuItems as $k=>$menu){
      $newMenu[$k]=$menu;
      $newMenu[$k]['url'][0] = rtrim($menu['url'][0], "/");
    }
    $menuItems=$newMenu;
    //print_r($menuItems);
    //$nav = new Navigate();
    echo Menu::widget([
        'options' => ['class' => 'nav nav-tabs bar_tabs'],
        'encodeLabels' => false,
        //'activateParents' => true,
        //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
        'items' => $menuItems,
    ]);
    ?>
      
      
     
      
    </div>
</div>




<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel tile">
            <div class="x_title">
                <h2><?= $this->title; ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                <!--<div class="alert alert-warning alert-dismissible fade in" role="alert">-->
                <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>-->
                <!--    </button>-->
                <!--    <strong>ขออภัย ! </strong>-->
                <!--    ระบบกำลังปรับปรุงเป็นรูปแบบ Wizard Form-->
                <!--</div>-->
                  
                  
                  
                <?php echo $content; ?>
                
                
                <!--<div class="alert alert-info alert-dismissible fade in" role="alert">-->
                <!--    <strong></strong>-->
                <!--    ระบบกำลังปรับปรุงเป็นรูปแบบ Wizard Form-->
                <!--</div>-->
                
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
