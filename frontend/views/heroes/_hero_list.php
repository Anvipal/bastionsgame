<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 02.06.2015
 * Time: 22:32
 */
/**
 * @var $heroes \common\models\Hero[]
 */

use \common\models\Hero;
use \yii\helpers\html;

?>
<? foreach ($heroes as $hero): ?>
    <div id="h_<?= $hero->id ?>" class="hero-info">
        <img src="<?= $hero->heroclassimg ?>" alt=""/>

        <div class="hero-inner-info">
            <span class="hero-name"><?= $hero->hname ?></span>
            <span><?= $hero->heroclassname ?>, <?= $hero->hlevel ?> рівень</span>
        </div>
        <br/>

        <div class="hero-power">
            <img src="/img/hero/power/<?= $hero->hclass . Hero::HS_FIRST ?>.jpg"/>
            <span class="hero-power-info"><?= $hero->heroskills[Hero::HS_FIRST]['name'] ?></span>
        </div>

        <? if ($hero->heroskills[Hero::HS_SECOND]): ?>
            <div class="hero-power">
                <img src="img/hero/power/<?= $hero->hclass . Hero::HS_SECOND ?>.jpg"/>
                <span class="hero-power-info"><?= $hero->heroskills[Hero::HS_SECOND]['name'] ?></span>
            </div>
        <? else: ?>
            <div class="hero-power">
                <img src="/img/hero/power/not_avaliable_10.jpg"/>
                <span class="hero-power-info">Досягніть 10 рівня, щоб отримати доступ до другої переваги!</span>
            </div>
        <? endif; ?>

        <? if ($hero->heroskills[Hero::HS_THIRD]): ?>
            <div class="hero-power">
                <img src="img/hero/power/<?= $hero->hclass . Hero::HS_THIRD ?>.jpg"/>
                <span class="hero-power-info"><?= $hero->heroskills[Hero::HS_THIRD]['name'] ?></span>
            </div>
            <br/>
        <? else: ?>
            <div class="hero-power">
                <img src="/img/hero/power/not_avaliable_20.jpg"/>
                <span class="hero-power-info">Досягніть 20 рівня, щоб отримати доступ до третьої переваги!</span>
            </div>
        <? endif; ?>

        <div>
            <?= isset($hero->questhero)
                ? 'Зараз на завданні' . '<br/>' . Html::a('/quests/view/' . $hero->questhero->quest->id, $hero->questhero->quest->name)
                : Html::a('Почати завдання', '/quest/');
            ?>
            <?= Html::a('Звільнити', '/heroes/delete/' . $hero->id, ['class' => 'hero-delete']); ?>
        </div>
    </div>
<? endforeach; ?>