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
use yii\widgets\ActiveForm;
use common\models\StdHero;


$form = ActiveForm::begin([
    'id' => 'hero_form',
    'options' => [
        'class' => 'form-hero-hire',
        'enctype' => 'multipart/form-data'
    ]
]);
echo $form->field($model, 'title')->textInput();
echo $form->field($model, 'id_stdhero')->dropDownList(ArrayHelper::map(StdHero::find()->select(['id', 'name'])->asArray()->all(), 'id', 'name'));
ActiveForm::end();
$this->registerJs("
    $('#hire_accept').on('click', function (e) {
        $.ajax({
            url: '/heroes/hire/',
            type: 'POST',
            data: $('#hero_form').serialize()
        }).done(function (response) {
            $('#hero_hire').html(response);
            HeroUpdate();
        }).fail(function (response) {
            $('#hero_hire').html(response);
        });
    });
    $('#hire_cancel').on('click', function (e) {
        $('#hero_hire').modal('hide').html('');
    });
");
