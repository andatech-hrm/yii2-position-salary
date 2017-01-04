<?php

namespace andahrm\positionSalary;

/**
 * positionSalary module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'andahrm\positionSalary\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
       $this->layout= 'main';
        parent::init();

        // custom initialization code goes here
    }
}
