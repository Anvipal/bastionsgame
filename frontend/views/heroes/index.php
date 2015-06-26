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

Pjax::begin();

echo ListView::widget([
    'dataProvider' => $heroes,
    'emptyText' => 'Жодного героя ще не найнято',
    'itemOptions' => ['class' => 'item'],
    'itemView' => '_hero_item',
    'layout' => '{items}',
]);

Pjax::end(); ?>
<?= Html::a('Найняти героя', 'javascript:void(0);', ['id' => 'hero_buy', 'class' => 'hero-buy']) ?>
<?
echo Modal::widget([
    'id' => 'hero_hire',
    'header' => '<h4>Найняти нового героя</h4>' . Html::a('X', 'javascript:void(0);', ['class' => 'btn btn-popup-close', 'data-dismiss' => 'modal']),
    'footer' => Html::a('Найняти героя', 'javascript:void(0);', ['id' => 'hire_accept']) . Html::a('Відмінити', 'javascript:void(0);', ['id' => 'hire_cancel']),
]);
$this->registerJs(
    '$(\'#hero_buy\').on(\'click\', function () {
            $.ajax({
                url: \'/heroes/hire\',
                type: \'GET\'
            }).done(function(data){
                $(\'.modal-body\').html(data);
                $(\'#hero_hire\').modal(\'show\');
            });
        });'
);
?>

<script>
    (function () {
        $(document).ready(function () {
            function HeroUpdate() {
                $.ajax({
                    type: 'GET',
                    url: '/heroes/'
                }).done(function (response) {
                    $('#hero_list').html(response);
                });
            }
            $('.hero-delete').on('click', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: $(e.target).prop('href')
                }).done(function (response) {
                    if (response.err != undefined) {
                        var msg = response.msg;
                        console.log(response.err);
                    }
                    HeroUpdate();
                });
                return false;
            });
        });
    })();
</script>