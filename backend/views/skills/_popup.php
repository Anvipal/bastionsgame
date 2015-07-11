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
    <div id="popup-title"><?= \Yii::t('backend','TITLE_STDHEROSKILL_POPUP'); ?></div>
    <div class="close">X</div>
</div>

<?= \backend\widgets\popup\Tabs::widget([
    'model' => $model,
    'template' => '',
]); ?>

<?= \backend\widgets\popup\mainContent::widget(['content' => $content]); ?>

