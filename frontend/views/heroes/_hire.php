<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 01.06.2015
 * Time: 22:33
 *
 * @var $this \yii\web\View
 * @var $model \common\models\Hero
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use common\models\StdHero;

$form = ActiveForm::begin([
    'id' => 'hire-hero-form',
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]);
?>
    <div class="form-group">
        <?= $form->field($model, 'title')->textInput(['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'id_stdhero')->dropDownList(ArrayHelper::map(StdHero::find()->select(['id', 'name'])->asArray()->all(), 'id', 'name')) ?>
    </div>
<?
ActiveForm::end();

