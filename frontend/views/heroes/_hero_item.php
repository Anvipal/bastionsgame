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

use \yii\helpers\html;
use \yii\helpers\Url;

?>
<div class="hero-item">
    <div class="hero-inner-info">
        <span class="hero-title"><?= $model->title ?></span>
        <span><?= $model->idStdhero->name ?>, <?= $model->hlevel ?> рівень</span>
    </div>
    <br/>

    <div>
        <?= isset($model->idQuest)
            ? 'Зараз на завданні' . '<br/>' . Html::a($model->idQuest->idStdQuest->title, Url::toRoute('/quests/view', ['id' => $model->idQuest->id] ),['data-pjax' => 0])
            : Html::a('Почати завдання', Url::toRoute('/quests'), ['data-pjax' => 0]);
        ?>
        <?= Html::a('Звільнити', Url::toRoute(['/heroes/delete', ['id' => $model->id]]) , ['class' => 'hero-delete', 'data-pjax' => 0]); ?>
    </div>
</div>
