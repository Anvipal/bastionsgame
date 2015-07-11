<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 21:43
 */

/**
 * @var $view string;
 * @var $model common\models\StdHero
 * @var $content string
 */
use yii\helpers\Url;

?>

<div class="header">
    <div id="popup-title"><?= \Yii::t('backend','TITLE_STDOBSTACLE_POPUP') ?></div>
    <div class="close">X</div>
</div>

<?= \backend\widgets\popup\Tabs::widget([
    'model' => $model,
    'template' => $model->isNewRecord ? '' : ('{view} {update} {delete}'),
    'buttons' => [
        'delete' => [
            'url' => '#delete-obstacle',
            'title' => 'Видалити',
        ]
    ],
]); ?>

<?= \backend\widgets\popup\mainContent::widget(['content' => $content]); ?>

<?= \backend\widgets\popup\confirmContent::widget([
    'id' => 'delete-obstacle',
    'url' => Url::to(['obstacles/delete', 'id' => $model->id]),
    'content' => \Yii::t('backend','MSG_STDOBSTACLE_DELETE_CONFORM'),
    'pjaxUpdate' => 'pjax-obstacles'
]); ?>
