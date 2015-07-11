<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 22:18
 */
/**
 * @var $this yii\web\View
 * @var $model common\models\StdObstacle
 */

$this->title = \Yii::t('backend','TITLE_STDOBSTACLE_VIEW')

?>
<div class="heroes-view popup-content new-view">
    <div class="heroes-name-wrap">
        <span><?= $model->getAttributeLabel('title'); ?></span>
        <span><?= $model->title; ?></span>
    </div>
</div>