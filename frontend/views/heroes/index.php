<?php
/**
 * @var $this \yii\web\View
 * @var $heroes \yii\db\ActiveQuery
 */
use \yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use \yii\helpers\Url;
use \yii\widgets\Pjax;
use \yii\widgets\ListView;
use \yii\widgets\ActiveForm;
use \common\models\StdHero;
use \yii\bootstrap\Modal;

$this->title = 'Bastions - Heroes';

Pjax::begin(['id' => 'hero_list']);

echo ListView::widget([
    'dataProvider' => $heroes,
    'emptyText' => 'Жодного героя ще не найнято',
    'itemOptions' => ['class' => 'item'],
    'itemView' => '_hero_item',
    'layout' => '{items}',
]);

Pjax::end(); ?>
<?= Html::a('Найняти героя', 'javascript:void(0);', ['id' => 'hero_buy', 'class' => 'hero-buy btn btn-default']) ?>
<?
echo Modal::widget([
    'id' => 'hero_hire',
    'header' => '<h4>Найняти нового героя</h4>',
    'footer' => Html::button('Найняти героя', ['id' => 'hire_accept', 'class'=>'btn btn-primary']) . Html::button('Відмінити', ['data-dismiss' => 'modal', 'class'=>'btn btn-default']),
]);
$this->registerJs(
    "$('#hero_buy').on('click', function () {
            $.ajax({
                url: '/heroes/hire',
                type: 'GET'
            }).done(function(data){
                $('.modal-body').html(data);
                $('#hero_hire').modal('show');
            });
        });
        $('.hero-delete').on('click', function (e) {
                $.ajax({
                    type: 'GET',
                    url: $(e.target).prop('href')
                }).done(function (response) {
                    $.pjax.reload({container:'#hero_list'});
                });
                return false;
            });

        "

);
?>