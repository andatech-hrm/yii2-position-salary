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

<?php /*
<div class="row hidden-print">
    <div class="col-md-12"> 
      
      <?php
      $menuItems = [];
    $menuItems[] =  [
           'label' => '<i class="fa fa-sitemap"></i> ' . Yii::t('andahrm/position-salary', 'Person Position Salaries'),
            'url' => ["/{$module}/default/"],
     ];

    $menuItems[] =  [
            'label' => Html::icon('inbox') . ' ' . Yii::t('andahrm/position-salary',  'Calculator'),
            'url' => ["/{$module}/calculator/"],
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

*/ ?>


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
