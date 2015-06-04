<?php
/**
 * @var $this \yii\web\View
 * @var $heroes \app\models\Hero[]
 */
use \yii\helpers\Html;

$this->title = 'Bastions - Heroes';
?>
<div class="heroes-wrap">
    <div id="hero_list">
        <?= $this->render('_hero_list', ['heroes' => $heroes]); ?>
    </div>
    <?= Html::a('Найняти героя', 'javascript:void(0);', ['id' => 'hero_buy', 'class' => 'hero-buy']) ?>
    <div class="popup-wrapper popup">
    </div>
    <div id="popup_hero" class="popup">
    </div>
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
                        url: 'heroes/hire'
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
                    url: '/heroes/hire',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#hero_form').serialize()
                }).done(function (response) {
                    if (response.err != undefined) {
                        var msg = response.msg;
                        console.log(response.err);
                    }
                    HeroUpdate();
                });
                $('.popup').hide();
                $('#popup_hero').html('');
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