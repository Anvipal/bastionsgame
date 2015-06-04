<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 01.06.2015
 * Time: 22:33
 *
 * @var $this \yii\web\View
 * @var $model \app\models\Hero
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<div class="popup-wrap">
    <?
    $form = ActiveForm::begin([
        'id' => 'hero_form',
        'options' => [
            'class' => 'form-hero-hire',
            'enctype' => 'multipart/form-data'
        ]
    ]);
    ?>
    <?= $form->field($model, 'hname')->textInput(); ?>
    <?= $form->field($model, 'hclass')->dropDownList($model::heroclassname_list()) ?>
    <?= Html::a('Найняти героя', 'javascript:void(0);', ['id' => 'hire_accept']) ?>
    <?= Html::a('Відмінити', 'javascript:void(0);', ['id' => 'hire_cancel']) ?>
    <? ActiveForm::end(); ?>
</div>