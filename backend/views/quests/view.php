<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 22:18
 */
/**
 * @var $this yii\web\View
 * @var $model common\models\StdQuest
 */

$this->title = Yii::t('backend', 'TITLE_STDQUEST_VIEW')

?>
<div class="quests-view popup-content new-view">
    <div class="quests-title-wrap">
        <span><?= $model->getAttributeLabel('title'); ?></span>
        <span><?= $model->title; ?></span>
    </div>
    <? if ($model->idObstaclequest): ?>
        <div class="obstacles-wrap">
            <? foreach ($model->idObstaclequest as $obstaclequest):
                for ($i = 0; $i < $obstaclequest->cnt; $i++): ?>
                    <span><?= $obstaclequest->idObstacle->getAttributeLabel('title'); ?></span>
                    <span><?= $obstaclequest->idObstacle->title; ?></span>
                    <br/>
                <? endfor;
            endforeach; ?>
        </div>
    <? endif; ?>
</div>