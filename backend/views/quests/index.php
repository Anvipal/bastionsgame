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

$this->title = Yii::t('backend','TITLE_STDQUEST_EDITOR');
?>
<h1 class="main-title"><?= \yii\bootstrap\Html::encode($this->title); ?></h1>
<div class="quests-index summary_table">
    <? \yii\widgets\Pjax::begin(['id' => 'pjax-quests', 'options'=>['class'=>'main-grid-block']]) ?>
    <?=\backend\components\grid\GridView::widget([
        'id'=>'grid-view-quests',
        'dataProvider' => $dataProvider,
        'footerButtons' => [
            [
                'title' => Yii::t('backend','STDQUEST_ADD_BUTTON'), //'Додати героя',
                'url' => ['create'],
                'class' => 'grey-btn btn'
            ]
        ],
        'columns' => [
            ['attribute' => 'title']
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