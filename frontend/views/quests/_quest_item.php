<?php
/**
 * Created by PhpStorm.
 * User: Alexan
 * Date: 29.06.2015
 * Time: 11:43
 */

/**
 * @var $model \common\models\Quest
 */

use \yii\helpers\html;
use \yii\helpers\Url;
use \common\models\Quest;

?>
<div class="quest-item">
    <div class="quest-inner-info">
        <span class="quest-title"><?= $model->idStdquest->name; ?></span><br/>
        <?= $model->status == Quest::ST_NEW ? Html::tag('span','Нове завдання', ['class' => 'quest-status-new']) : Html::tag('span','Виконується', ['class' => 'quest-status-process']); ?>
    </div>
    <div>
        <?= isset($model->idQuest)
            ? 'Зараз на завданні' . '<br/>' . Html::a($model->idQuest->idStdQuest->title, Url::toRoute(['/quests/view', 'id' => $model->idQuest->id ]),['class' => 'btn btn-default','data-pjax' => 0])
            : Html::a('Почати завдання', Url::toRoute(['/quests']), ['class' => 'btn btn-default', 'data-pjax' => 0]);
        ?>
        <?= Html::a('Звільнити', Url::toRoute(['heroes/delete', 'id' => $model->id]) , ['class' => 'btn btn-default hero-delete', 'data-pjax' => 0]); ?>
    </div>
</div>