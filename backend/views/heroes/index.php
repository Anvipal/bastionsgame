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

$this->title = Yii::t('backend','TITLE_STDHERO_EDITOR');
?>
<h1 class="main-title"><?= \yii\bootstrap\Html::encode($this->title); ?></h1>
<div class="heroes-index summary_table">
    <? \yii\widgets\Pjax::begin(['id' => 'pjax-heroes', 'options'=>['class'=>'main-grid-block']]) ?>
    <?=\backend\components\grid\GridView::widget([
        'id'=>'grid-view-heroes',
        'dataProvider' => $dataProvider,
        'footerButtons' => [
            [
                'title' => Yii::t('backend','STDHERO_ADD_BUTTON'), //'Додати героя',
                'url' => ['create'],
                'class' => 'grey-btn btn'
            ]
        ],
        'columns' => [
            ['attribute' => 'name']
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