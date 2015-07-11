<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 22:17
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StdHero */

$this->title = \Yii::t('backend','TITLE_STDOBSTACLE_UPDATE');
?>
<div class="heroes-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>