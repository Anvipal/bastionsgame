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

$this->title = Yii::t('backend', 'TITLE_STDHERO_VIEW')

?>
<div class="heroes-view popup-content new-view">
    <div class="heroes-name-wrap">
        <span><?= $model->getAttributeLabel('name'); ?></span>
        <span><?= $model->name; ?></span>
    </div>
    <? if (!empty($model->idStdSkills)): ?>
    <div class="heroes-skills-wrap">
        <h4><?= Yii::t('backend', 'STDHERO_SKILLS') ?></h4>
        <? foreach ($model->idStdSkills as $skill): ?>
            <span><?= $skill->getAttributeLabel('title'); ?></span>
            <span><?= $skill->title; ?></span>
            <div class="heroes-skills-obscales-wrap">
                <span><?= $skill->idStdobstacle->getAttributeLabel('title') ?></span>
                <span><?= $skill->idStdobstacle->title; ?></span>
            </div>
        <? endforeach; ?>
    </div>
    <? endif; ?>
</div>