<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 22:09
 */

/**
 * @var $this yii\web\View
 * @var $model common\models\StdQuest
 * @var $form yii\bootstrap\ActiveForm
 */

use yii\helpers\ArrayHelper;

?>
<? $form = \yii\bootstrap\ActiveForm::begin([
    'id' => 'quests-form',
    'options' => [
        'class' => 'form-fill',
        'data-ajax' => 1,
        'data-grid-view' => '#grid-view-quests',
        'data-pjax-container' => '#pjax-quests',
    ]
]); ?>
<?= $form->field($model, 'title')->textInput(); ?>
<? $ddl = str_replace("\n",'',\yii\helpers\Html::dropDownList('StdQuest[obstacles][]',null,ArrayHelper::map(\common\models\StdObstacle::find()->select(['title', 'id'])->all(),'id','title'))); ?>
<div id="obstacle-input-wrap">
    <? if ($model->idObstacles): ?>
    <? endif; ?>
</div>
<?= \yii\helpers\Html::a(Yii::t('backend','BUTTON_ADD'),'javascript:void(0);',['class' => 'btn btn-default', 'id'=>'add_obstacle', 'data-disable-ajax' => 0]); ?>

<? $this->registerJs(
    <<<JS
    $('#add_obstacle').on('click',function(){
        console.log('$ddl');
        $('#obstacle-input-wrap').append('$ddl').join('<br/>');
    });
JS
); ?>
<div class="form-group confirm-btn-wrap">
    <?= \yii\bootstrap\Html::submitButton($model->isNewRecord ? \Yii::t('common','BUTTON_CREATE') : \Yii::t('common','BUTTON_SAVE'), [
        'class' => 'btn-ok btn btn-ok-mini'
    ]); ?>
</div>
<? \yii\bootstrap\ActiveForm::end(); ?>