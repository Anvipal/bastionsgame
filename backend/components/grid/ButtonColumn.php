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
    public $template = '{update} {delete} {assign}';

    public function init()
    {

        $this->header = 'Дії';
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                return Html::a( 'Оновити', $url, ['title' => 'Оновити', 'data-pjax' => '0']);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                /** @var $model ActiveRecord */
                if($model->hasAttribute('const')){
                    if(is_null($model->const)) {
                        return Html::a( 'Видалити', $url, ['data-confirm'=>'Видалити?','title' => 'Видалення', 'data-method'=>'POST' ]);
                    } else {
                        return 'Видалити';
                    }
                } else {
                    return Html::a( 'Видалити', $url, ['data-confirm'=>'Видалити?','title' => 'Видалення', 'data-method'=>'POST' ]);
                }
            };
        }
        parent::init();
    }
}