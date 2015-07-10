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

class confirmContent extends Widget{

    public $url;
    public $content;
    public $title;
    public $pjaxUpdate = false;
    public function run(){

        //$this->id = $this->id.'_confirm_button';

        $tmp = '';//Html::tag('a',$this->title,['href'=>"#{$this->id}", 'class'=>'popup-tab']);

        $cancel=Html::tag('a',Yii::t('app','Cancel'),['class'=>'btn-cancel btn btn-cancel-mini','rel'=>'close','href'=>'#']);

        $ok=Html::tag('a',Yii::t('app','Ok'),['class'=>'btn-ok btn btn-ok-mini','href'=>$this->url, 'id'=>'btn-ok-'.$this->id ]);

        $content = Html::tag('div', $this->content, [ 'class'=>'confim_message' ]);

        $tmp.=Html::tag('div', $content."<div class='confirm-btn-wrap'>".$ok.$cancel."</div>",['id'=>$this->id,'class'=>'popup-body static-content']);
        Yii::$app->view->registerJs("

        $('#btn-ok-{$this->id}').click(function(e){
            e.preventDefault();
            $.post('{$this->url}').done(function(res){
                $.popup().close();
                ".($this->pjaxUpdate?"$.pjax.reload({container: '#{$this->pjaxUpdate}', timeout: 5000 });":"")."
            });
            return false;
        });

        ");
        return $tmp;
    }

}