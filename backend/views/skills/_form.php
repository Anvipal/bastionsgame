<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 22:09
 */

/**
 * @var $this yii\web\View
 * @var $model common\models\StdHeroSkill
 * @var $form yii\bootstrap\ActiveForm
 */

?>
<? $form = \yii\bootstrap\ActiveForm::begin([
    'id' => 'skill-form',
    'options' => [
        'class' => 'form-fill',
        'data-ajax' => 1,
        'data-grid-view' => '#grid-view-heroes',
        'data-pjax-container' => '#pjax-heroes',
    ]
]); ?>
<?
if ($model->isNewRecord)
    echo $form->field($model, 'id_stdhero')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\StdHero::find()->select('id', 'name')->all(), 'id', 'name'));
else
    $form->field($model, 'id_stdhero')->hiddenInput();
?>
<?
if ($model->isNewRecord)
    echo $form->field($model, 'id_stdobstacle')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\StdObstacle::find()->select('id', 'title')->all(), 'id', 'title'));
else
    echo $form->field($model, 'id_stdobstacle')->hiddenInput();
?>
<?= $form->field($model, 'title')->textInput(); ?>
    <div class="form-group confirm-btn-wrap">
        <?= \yii\bootstrap\Html::submitButton($model->isNewRecord ? 'Створити' : 'Зберегти', [
            'class' => $model->isNewRecord ? 'btn-ok btn btn-ok-mini' : 'btn-ok btn btn-ok-mini'
        ]); ?>
    </div>
<? \yii\bootstrap\ActiveForm::end(); ?>