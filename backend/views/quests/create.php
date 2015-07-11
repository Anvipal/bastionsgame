<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 22:15
 */

/**
 * @var $this yii\web\View
 * @var $model common\models\StdQuest
 */

$this->title = Yii::t('backend','TITLE_STDHERO_CREATE');

?>
<div class="quests-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>