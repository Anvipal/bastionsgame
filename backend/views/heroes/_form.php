<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 22:09
 */

/**
 * @var $this yii\web\View
 * @var $model common\models\StdHero
 * @var $form yii\bootstrap\ActiveForm
 */

?>
<? $form = \yii\bootstrap\ActiveForm::begin([
    'id' => 'heroes-form',
    'options' => [
        'class' => 'form-fill',
        'data-ajax' => 1,
        'data-grid-view' => '#grid-view-heroes',
        'data-pjax-container' => '#pjax-heroes',
    ]
]); ?>
<?= $form->field($model, 'name')->textInput(); ?>
<div class="form-group confirm-btn-wrap">
    <?= \yii\bootstrap\Html::submitButton($model->isNewRecord ? \Yii::t('common','BUTTON_CREATE') : \Yii::t('common','BUTTON_SAVE'), [
        'class' => 'btn-ok btn btn-ok-mini'
    ]); ?>
</div>
<? \yii\bootstrap\ActiveForm::end(); ?>