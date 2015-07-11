<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 22:18
 */
/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model common\models\StdHero
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="skills-view popup-content new-view">
    <?= \backend\components\grid\GridView::widget([
        'id' => 'skills-grid',
        'dataProvider' => $dataProvider,
        'footerButtons' => [
            [
                'title' => \Yii::t('backend', 'STDHEROSKILL_ADD_BUTTON'),
                'url' => ['create-skill', 'id_stdhero' => $model->id],
                'class' => 'new-add grey-btn btn'
            ]
        ],
        'columns' => [
            'title',
            [
                'label' => 'Перевага',
                'attribute' => 'idStdobstacle.title'
            ],
            [
                'class' => 'backend\components\grid\ButtonColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        /** @var $model common\models\StdHeroSkill */
                        return Html::a(\Yii::t('common', 'BUTTON_UPDATE'), Url::to(['update-skill', 'id_stdhero' => $model->id_stdhero, 'id_stdobstacle' => $model->id_stdobstacle]), ['title' => Yii::t('common', 'BUTTON_UPDATE'), 'data-pjax' => '0']);
                    },
                    'delete' => function ($url, $model) {
                        /** @var $model common\models\StdHeroSkill */
                        return Html::a(\Yii::t('common', 'BUTTON_DELETE'), Url::to(['delete-skill', 'id_stdhero' => $model->id_stdhero, 'id_stdobstacle' => $model->id_stdobstacle]), ['data-confirm' => Yii::t('common', 'MSG_GRID_DELETE'), 'title' => Yii::t('common', 'BUTTON_DELETE'), 'data-method' => 'POST']);
                    }
                ]
            ]
        ]
    ])
    ?>
    <?
    $this->registerJs(
        <<<JS
    $("#skills-grid").on("click", "tbody tr", function (e) {
    console.log(e.target.tagName);
    if(e.target.tagName != 'A')
    {
        e.stopImmediatePropagation();
        e.preventDefault();
        return false;
    }
    return true;
    });
JS
    )
    ?>
</div>
