<?php
/**
 * @var $this \yii\web\View
 * @var $heroes \yii\db\ActiveQuery
 */
use \yii\helpers\Html;
use \yii\helpers\Url;
use \yii\widgets\Pjax;
use \yii\widgets\ListView;

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
<div class="popup-wrapper popup">
</div>
<div id="popup_hero" class="popup">
</div>

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

            $('#hero_buy').on('click', function () {
                if ($('.popup').is(':visible') == false) {
                    $.ajax({
                        type: 'GET',
                        url: '/heroes/hire/'
                    }).done(function (popup) {
                        if (popup != undefined) {
                            $('#popup_hero').html(popup);
                        }
                    });
                    $('.popup').show();
                }
            });
            $('#popup_hero').on('click', '#hire_accept', function (e) {

                $.ajax({
                    url: '/heroes/hire/',
                    type: 'POST',
                    //dataType: 'json',
                    data: $('#hero_form').serialize()
                }).done(function (response) {
                    /*if (response.err != undefined) {
                     var msg = response.msg;
                     console.log(response.err);
                     }*/
                    $('#popup_hero').html(response);
                    HeroUpdate();
                }).fail(function (response) {
                    $('#popup_hero').html(response);
                });
                //$('.popup').hide();
                //$('#popup_hero').html('');
            }).on('click', '#hire_cancel', function (e) {
                $('.popup').hide();
                $('#popup_hero').html('');
            });
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