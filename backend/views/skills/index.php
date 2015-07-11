<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 21:30
 */

/**
 * @var $this yii\web\View;
 * @var $dataProvider yii\data\ActiveDataProvider;
 */

$this->title = \Yii::t('backend','TITLE_STDHEROSKILLS_EDITOR');
?>
<h1 class="main-title"><?= \yii\bootstrap\Html::encode($this->title); ?></h1>
<div class="skills-index summary_table">
    <? \yii\widgets\Pjax::begin(['id' => 'pjax-skills', 'options'=>['class'=>'main-grid-block']]) ?>
    <?=\backend\components\grid\GridView::widget([
        'id'=>'grid-view-skills',
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
        ]
    ]); ?>
    <? \yii\widgets\Pjax::end(); ?>
</div>
<style>
    .grid-view td,
    .grid-view th {
        width: auto;
    }
</style>