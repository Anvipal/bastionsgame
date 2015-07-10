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

$this->title = 'Редактор перешкод';
?>
<h1 class="main-title"><?= \yii\bootstrap\Html::encode($this->title); ?></h1>
<div class="obstacles-index summary_table">
    <? \yii\widgets\Pjax::begin(['id' => 'pjax-obstacles', 'options'=>['class'=>'main-grid-block']]) ?>
    <?=\backend\components\grid\GridView::widget([
        'id'=>'grid-view-obstacles',
        'dataProvider' => $dataProvider,
        'footerButtons' => [
            [
                'title' => 'Додати перешкоду',
                'url' => ['create'],
                'class' => 'new-add grey-btn btn'
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