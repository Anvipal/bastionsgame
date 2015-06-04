<?php
/* @var $this yii\web\View */
use \yii\helpers\Html;

$this->title = 'Bastions - Main Page';
?>
<div class="site-index">
    <div class="main-quests-wrap">
        <?= Html::a('Завдання', '/quests/', ['class' => 'button']) ?>
    </div>
    <div class="main-heroes-wrap">
        <?= Html::a('Герої', '/heroes/', ['class' => 'button']) ?>
    </div>
</div>
