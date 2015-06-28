<?php
/**
 * @var $this \yii\web\View
 * @var $quests \common\models\Quest[]
 */

use common\models\Quest;

$this->title = 'Bastion - Quests';
?>
    <? foreach ($quests as $quest): ?>
        <div class="quest-info">
            <img class="quest-img" src=""/>
            <? if ($quest->status == Quest::ST_NEW): ?>
                <span><?= date('H:i', $quest->timetodo); ?></span>
            <? elseif ($quest->status == Quest::ST_IN_PROCESS): ?>
                <div id="quest_bar_<?= $quest->id ?>" style="width:100%; height:50px; border:1px solid black;">
                    <div id="progress_quest_bar_<?= $quest->id ?>"
                         style="width:<?= round(((time() - $quest->timestart) * 100) / $quest->timetodo, 0, PHP_ROUND_HALF_DOWN) ?>%; height:45px;">
                    </div>
                </div>
            <? endif; ?>
        </div>
        <div>
            <span><?= $quest->name; ?></span>
            <span><?= $quest->statusname . ', ' . date('H:i',(time() - $quest->timestart)); ?></span>
            <? if ($quest->isNew): ?>
                <span>Середній рівень: <?= $quest->midhlevel ?></span>
            <? endif; ?>
            <div>

            </div>
        </div>
    <? endforeach; ?>