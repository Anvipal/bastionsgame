<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 21:43
 */

/**
 * @var $view string;
 * @var $model common\models\StdQuest
 * @var $content string
 */
use yii\helpers\Url;

?>

<div class="header">
    <div id="popup-title"><?= \Yii::t('backend','TITLE_STDQUESTS_POPUP') ?></div>
    <div class="close">X</div>
</div>

<?= \backend\widgets\popup\Tabs::widget([
    'model' => $model,
    'template' => $model->isNewRecord ? '' : ('{view} {update} {delete}'),
    'buttons' => [
        'delete' => [
            'url' => '#delete-quest',
            'title' => \Yii::t('common','BUTTON_DELETE'),
        ]
    ],
]); ?>

<?= \backend\widgets\popup\mainContent::widget(['content' => $content]); ?>

<?= \backend\widgets\popup\confirmContent::widget([
    'id' => 'delete-quest',
    'url' => Url::to(['quests/delete', 'id' => $model->id]),
    'content' => Yii::t('backend','MSG_DELETE_STDQUESTS_CONFIRM'),
    'pjaxUpdate' => 'pjax-quests'
]); ?>
