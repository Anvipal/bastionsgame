<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<? NavBar::begin([
    'brandLabel' => 'Admin Bastions',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-default'
    ]
]);

echo Nav::widget([
    'options' => [
        'class' => 'navbar-nav navbar-left'
    ],
    'items' => [
        [
            'label' => Yii::t('backend','NAV_STDHEROES'),
            'url' => ['/heroes']
        ],

        [
            'label' => Yii::t('backend','NAV_STDOBSTACLES'),
            'url' => ['/obstacles'],
        ],
        [
            'label' => Yii::t('backend','NAV_STDQUESTS'),
            'url' => ['/quests'],
        ],
        [
            'label' => Yii::t('backend','NAV_STDHEROSKILLS'),
            'url' => ['/skills'],
        ],
    ]
]);
NavBar::end(); ?>
<div class="container">
    <?= $content ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
