<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 02.06.2015
 * Time: 22:32
 */
/**
 * @var $model \common\models\Hero
 */

use \common\models\Hero;
use \yii\helpers\html;

?>
<div class="hero-item">
    <div class="hero-inner-info">
        <span class="hero-title"><?= $model->title ?></span>
        <span><?= $model->idStdhero->name ?>, <?= $model->hlevel ?> рівень</span>
    </div>
    <br/>
    <div>
        <?= $model->onMission
            ? 'Зараз на завданні' . '<br/>' . Html::a('/quests/view/' . $model->idQuest->id, $model->idQuest->idStdQuest->title)
            : Html::a('Почати завдання', '/quest/');
        ?>
        <?= Html::a('Звільнити', '/heroes/delete/' . $model->id, ['class' => 'hero-delete']); ?>
    </div>
</div>
