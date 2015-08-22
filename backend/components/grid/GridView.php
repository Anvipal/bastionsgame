<?php

namespace backend\components\grid;

use yii\helpers\Html;

class GridView extends \yii\grid\GridView {

    public $tableOptions = ['class' => 'table table-striped table-bordered table-hover'];

    public $dataController = null;
    public $dataAction = 'view';
    public $usePopup = true;
    public $layout = '{items}';
    public $footerButtons = [];
    public $disableRowClick = false;

    public function init()
    {
        parent::init();

        $this->emptyText = $this->emptyText ?: \Yii::t('backend','MSG_TABLE_EMPTY');

        if($this->dataController === null){
            $this->dataController = $this->view->context->id;
        }
        //$this->dataAction = 'view';

        if($this->dataController) {
            $this->tableOptions['data-common-controller'] = $this->dataController;
        }
        $this->tableOptions['data-common-action'] = $this->dataAction;

        $this->tableOptions['data-use-popup'] = $this->usePopup ? '1' : '0';
        if (is_array($this->footerButtons) && !empty($this->footerButtons))
        {
            $this->showFooter = true;
        }
        if (!$this->disableRowClick) {
            $this->view->registerJs(
                <<<JS
                $("body").on("click", "table tbody tr", function (e) {
                var it = $(this),
                    table = it.parents('table'),
                    id = it.attr('data-id') || it.attr('data-key'),
                    action = it.attr('data-action') || table.attr("data-common-action") || "view",
                    controller = it.attr('data-controller') || table.attr("data-common-controller");

                if( table.attr('data-use-popup') == '1' ){
                    if (id && controller && action && !$(e.target).is("input,i,a,img") ) {
                        $.popup().showURL("/" + controller + "/" + action + "/" + id);
                    }
                } else {
                    if(controller && action && !$(e.target).is("input,i,a,img") ){
                        if(it.attr('data-id'))
                            window.location = "/" + controller + "/" + action + "/" + it.attr('data-id');
                        else
                            window.location = "/" + controller + "/" + action
                    }
                }
            });
JS

            );
        }
    }

    public function renderTableFooter()
    {
        $content = "<tr><td colspan=\"".count($this->columns)."\"><div style=\"text-align:center;\">";
        foreach ($this->footerButtons as $button)
        {
            $content .= \yii\bootstrap\Html::a($button['title'] ?: '', $button['url'] ?: '', ['class' => $button['class'] ?: '', 'data-disable-popup' => $button['disablePopup'] ?: null]);
        }
        $content.= '</div></td></tr>';
        $this->view->registerJs(
            <<<JS
            $("body").on("click", "tfoot tr td div a", function(){
                var it = $(this);
                if (it.attr("data-disable-popup") != undefined)
                {
                    $.popup().showURL(it.attr("href"));
                }
                e.preventDefault();
                return false;
            });
JS
        );
        return "<tfoot>\n".$content."\n</tfoot>";
    }
}