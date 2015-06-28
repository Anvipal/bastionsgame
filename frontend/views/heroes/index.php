<?php
/**
 * @var $this \yii\web\View
 * @var $heroes \yii\db\ActiveQuery
 */
use \yii\helpers\Html;
use \yii\helpers\Url;
use \yii\widgets\Pjax;
use \yii\widgets\ListView;
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
<?= Html::button('Найняти героя', ['value' => Url::to(['heroes/hire']),'title' => 'Найняти героя', 'class' => 'btn btn-default showModalButton']) ?>
<?
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    'header' => '<h4>Найняти нового героя</h4>',
    'footer' => Html::button('Найняти героя', ['id' => 'hire_accept', 'class' => 'btn btn-primary']) . Html::button('Відмінити', ['data-dismiss' => 'modal', 'class' => 'btn btn-default']),
]);
echo '<div id="modalContent"></div>';

Modal::end();
$this->registerJs(
    <<<JS
        $('.hero-delete').on('click', function (e) {
                $.ajax({
                    type: 'GET',
                    url: $(e.target).prop('href')
                }).done(function (response) {
                    $.pjax.reload({container:'#hero_list'});
                });
                return false;
            });
            $('#hire_accept').on('click', function (e) {
        $.ajax({
            url: '/heroes/hire/',
            type: 'POST',
            data: $('#hire-hero-form').serialize()
        }).done(function (response) {
            $('#modal').find('#modalContent').html(response);
            $.pjax.reload({container:'#hero_list'});
        }).fail(function (response) {
            console.log(response);
        });
    });
    $('#hire_cancel').on('click', function (e) {
        $('#hero_hire').modal('hide').html('');
    });
    $(document).on('click','.showModalButton',function(){
        if ($('#modal').data('bs.modal').isShown){
            $('#modal').find('#modalContent').load($(this).attr('value'));
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        }else{
            $('#modal').modal('show').find('#modalContent').load($(this).attr('value'));
            document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        }
    });
JS
);
?>