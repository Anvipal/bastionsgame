<?php
/**
 * Created by PhpStorm.
 * User: ninazu
 * Date: 24.02.15
 * Time: 18:55
 */

namespace backend\widgets\popup;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class mainContent extends Widget{

    public $content;
    public $withoutButtons = false;
    public $options;

    public function run(){

        $view = Yii::$app->getView();

        if( !isset($this->options['class']) ){
            $this->options['class'] = 'popup-body popup-body-main';
        } else {
            $this->options['class'] = 'popup-body popup-body-main '.$this->options['class'];
        }

        if($view->params['without-buttons'] || $this->withoutButtons ){
            $this->options['class'] .= ' withoutbutton';
        }

        return Html::tag('div', $this->content, $this->options );
    }

}