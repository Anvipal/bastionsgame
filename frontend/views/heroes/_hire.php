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
    'id' => 'hero_form',
    'options' => [
        'class' => 'form-hero-hire',
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
$this->registerJs("
    $('#hire_accept').on('click', function (e) {
        $.ajax({
            url: '/heroes/hire/',
            type: 'POST',
            data: $('#hero_form').serialize()
        }).done(function (response) {
            $('.modal-body').html(response);
            $.pjax.reload({container:'#hero_list'});
        }).fail(function (response) {
            $('.modal-body').html(response);
        });
    });
    $('#hire_cancel').on('click', function (e) {
        $('#hero_hire').modal('hide').html('');
    });
");
