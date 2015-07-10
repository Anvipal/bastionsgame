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
    <div id="popup-title">Герой</div>
    <div class="close">X</div>
</div>

<?= \backend\widgets\popup\Tabs::widget([
    'model' => $model,
    'template' => $model->isNewRecord ? '' : ('{view} {update} {delete}'),
    'buttons' => [
        'delete' => [
            'url' => '#delete-hero',
            'title' => 'Видалити',
        ]
    ],
]); ?>

<?= \backend\widgets\popup\mainContent::widget(['content' => $content]); ?>

<?= \backend\widgets\popup\confirmContent::widget([
    'id' => 'delete-hero',
    'url' => Url::to(['heroes/delete', 'id' => $model->id]),
    'content' => 'Ви хочете видалити героя?',
    'pjaxUpdate' => 'pjax-heroes'
]); ?>