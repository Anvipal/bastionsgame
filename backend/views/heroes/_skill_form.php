<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 22:09
 */

/**
 * @var $this yii\web\View
 * @var $skill common\models\StdHeroSkill
 * @var $form yii\bootstrap\ActiveForm
 * @var $dropdownlists array
 */

?>
<? $form = \yii\bootstrap\ActiveForm::begin([
    'id' => 'skill-form',
    'options' => [
        'class' => 'form-fill',
        'data-ajax' => 1,
        'data-grid-view' => '#grid-view-skills',
        'data-pjax-container' => '#pjax-skills',
    ]
]); ?>
<?= $form->field($skill, 'id_stdhero')->hiddenInput()->label(false); ?>
<?
if ($skill->isNewRecord)
    echo $form->field($skill, 'id_stdobstacle')->dropDownList($dropdownlists['stdobstacles']);
else
    echo $form->field($skill, 'id_stdobstacle')->hiddenInput()->label(false);
?>
<?= $form->field($skill,'slevel')->dropDownList($skill->isNewRecord ? $skill->idStdhero->getSkillLevelAvailable() : $skill->idStdhero->getSkillLevelAvailable($skill->slevel)); ?>
<?= $form->field($skill, 'title')->textInput(); ?>
    <div class="form-group confirm-btn-wrap">
        <?= \yii\bootstrap\Html::submitButton($skill->isNewRecord ? \Yii::t('common','BUTTON_CREATE') : \Yii::t('common','BUTTON_SAVE'), [
            'class' => 'btn-ok btn btn-ok-mini'
        ]); ?>
        <?= \yii\bootstrap\Html::a(Yii::t('common','BUTTON_BACK'),\yii\helpers\Url::to(['skills', 'id'=>$skill->id_stdhero]),['class' => 'btn btn-cancel btn-cancel-mini']) ?>
    </div>
<? \yii\bootstrap\ActiveForm::end(); ?>