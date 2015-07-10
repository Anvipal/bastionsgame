<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 22:18
 */
/**
 * @var $this yii\web\View
 * @var $model common\models\StdHero
 */

?>
<div class="heroes-view popup-content new-view">
    <div class="heroes-name-wrap">
        <span><?= $model->getAttributeLabel('name'); ?></span>
        <span><?= $model->name; ?></span>
    </div>
</div>