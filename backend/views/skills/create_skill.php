<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 10.07.2015
 * Time: 22:15
 */

/**
 * @var $this yii\web\View
 * @var $model common\models\StdHeroSkill
 * @var $dropdownlists array
 */

$this->title = \Yii::t('backend','TITLE_STDHEROSKILL_CREATE');

?>
<div class="skill-create">
    <?= $this->render('_form', [
        'model' => $model,
        'dropdownlists' => $dropdownlists,
    ]); ?>
</div>