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

    public function init()
    {
        parent::init();

        $this->emptyText = 'Дані відсутні';

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
    }

    public function renderTableFooter()
    {
        $content = "<tr><td colspan=\"".count($this->columns)."\"><div style=\"text-align:center;\">";
        foreach ($this->footerButtons as $button)
        {
            $content .= \yii\bootstrap\Html::a($button['title'] ?: '', $button['url'] ?: '', ['class' => $button['class'] ?: '']);
        }
        $content.= '</div></td></tr>';
        return "<tfoot>\n".$content."\n</tfoot>";
    }
}