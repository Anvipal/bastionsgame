<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\components\grid;

use yii\db\ActiveRecord;
use Yii;
use yii\grid\ActionColumn;
use yii\helpers\Html;

class ButtonColumn extends ActionColumn {

    public $header ='';
    public $headerOptions = [ 'class'=>'actions-column' ];
    public $contentOptions = [ 'class'=>'button-column' ];
    public $template = '{update} {delete}';

    public function init()
    {

        $this->header =  Yii::t('common', 'TITLE_ACTIONS');
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                return Html::a( Yii::t('common', 'BUTTON_UPDATE'), $url, ['title' =>  Yii::t('common', 'BUTTON_UPDATE'), 'data-pjax' => '0']);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                /** @var $model ActiveRecord */
                if($model->hasAttribute('const')){
                    if(is_null($model->const)) {
                        return Html::a( Yii::t('common', 'BUTTON_DELETE'), $url, ['data-confirm'=>Yii::t('common', 'MSG_GRID_DELETE'),'title' => Yii::t('common', 'TITLE_DELETE'), 'data-method'=>'POST' ]);
                    } else {
                        return Yii::t('common', 'BUTTON_DELETE');
                    }
                } else {
                    return Html::a(  Yii::t('common', 'BUTTON_DELETE'), $url, ['data-confirm'=>Yii::t('common', 'MSG_GRID_DELETE'),'title' => Yii::t('common', 'BUTTON_DELETE'), 'data-method'=>'POST' ]);
                }
            };
        }
        parent::init();
    }
}