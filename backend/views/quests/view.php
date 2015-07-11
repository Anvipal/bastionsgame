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

$this->title = Yii::t('backend','TITLE_STDHERO_VIEW')

?>
<div class="quests-view popup-content new-view">
    <div class="quests-name-wrap">
        <span><?= $model->getAttributeLabel('name'); ?></span>
        <span><?= $model->name; ?></span>
    </div>

</div>