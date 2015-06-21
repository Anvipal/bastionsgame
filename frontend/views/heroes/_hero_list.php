<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 02.06.2015
 * Time: 22:32
 */
/**
 * @var $hero \common\models\Hero
 */

use \common\models\Hero;
use \yii\helpers\html;

?>
<div class="hero-item">
    <div class="hero-inner-info">
        <span class="hero-title"><?= $hero->title ?></span>
        <span><?= $hero->idStdhero->name ?>, <?= $hero->hlevel ?> рівень</span>
    </div>
    <br/>
    <div>
        <?= $hero->onMission
            ? 'Зараз на завданні' . '<br/>' . Html::a('/quests/view/' . $hero->questhero->quest->id, $hero->questhero->quest->name)
            : Html::a('Почати завдання', '/quest/');
        ?>
        <?= Html::a('Звільнити', '/heroes/delete/' . $hero->id, ['class' => 'hero-delete']); ?>
    </div>
</div>
