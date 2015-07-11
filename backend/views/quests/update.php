<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 22:17
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StdQuest */

$this->title = Yii::t('backend','TITLE_STDHERO_UPDATE');
?>
<div class="quests-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>