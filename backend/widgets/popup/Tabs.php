<?php
/**
 * Created by PhpStorm.
 * User: Yaroslav
 * Date: 26.02.2015
 * Time: 18:47
 *
 */

namespace backend\widgets\popup;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class Tabs extends Widget {

    public $controller;
    /**
     * @var \yii\db\ActiveRecord
     */
    public $model;

    public $buttons = [];
    public $template = '{view} {update}';

    public $commonUrlParams = [];

    public function init(){
        parent::init();

        if( $this->model ) {
            if (!isset($this->buttons['view'])) {
                $this->buttons['view'] = [
                    'title' => 'Перегляд',//Yii::t('app', 'View'),
                    'url' => Url::to(ArrayHelper::merge([
                        ($this->controller ? $this->controller.'/view':'view'),
                        'id' => $this->model->getPrimaryKey()
                    ], $this->commonUrlParams ))
                ];
            }
            if (!isset($this->buttons['update'])) {
                $this->buttons['update'] = [
                    'title' => 'Оновити',//Yii::t('app', 'Update'),
                    'url' => Url::to(ArrayHelper::merge([
                        ($this->controller ? $this->controller.'/update':'update'),
                        'id' => $this->model->getPrimaryKey()
                    ], $this->commonUrlParams)),
                ];
            }
        } else {
            throw new \Exception('Tabs не додано!', 500);
        }

    }

    public function run(){

        if( $this->template === false || $this->template == '' ){
            return '';
        }

        $buttons = [];
        foreach($this->buttons as $key => $options){
            if(is_array($options)){
                if(!isset($options['url'])){
                    //$options['url'][0] = $key;
                    //$options['url']['id'] = $this->model->id;
                    $options['url'] = ArrayHelper::merge( [
                        $key,
                        'id' => $this->model->getPrimaryKey()
                    ], $this->commonUrlParams );
                }

                /** @author aayaresko <aayaresko@gmail.com> */
                if(!isset($options['options']['title'])) {
                    $options['options']['title'] = ucfirst($key);
                }

                $buttons[$key] = $this->renderButton($options);
            } else if(is_string($options)) {
                $buttons[$key] = $options;
            } else {
                $this->template = preg_replace("/\{$key\}/", '', $this->template);
            }
        }

        $countButtons = 0;
        foreach($buttons as $key => $btn){
            $res = preg_replace("/\{$key\}/", $btn, $this->template);
            if($res != $this->template){
                $countButtons++;
                $this->template = $res;
            }
        }

        return Html::tag('div', $this->template, [
            'class' => 'popup-tab-wrap popup-tab-wrap-'.$countButtons
        ]);
    }


    private function renderButton($options){
        $htmlOpt = ArrayHelper::merge([
            'class' => 'popup-tab'
        ], (isset($options['options'])?$options['options']:[]) );

        if(isset($options['disabled'])) {
            if($options['disabled'] === true){
                $htmlOpt['class'] .= ' disabled';
                return Html::a($options['title'], '#false', $htmlOpt);
            }
        }

        return Html::a($options['title'], $options['url'], $htmlOpt);
    }
}