<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "questsheroes".
 *
 * @property string $id
 * @property string $heroes_id
 * @property string $quests_id
 *
 * @property Hero $hero
 * @property Quest $quest
 */
class QuestHero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questsheroes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'heroes_id', 'quests_id'], 'required'],
            [['id', 'heroes_id', 'quests_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'heroes_id' => 'Heroes ID',
            'quests_id' => 'Quests ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHero()
    {
        return $this->hasOne(Hero::className(), ['id' => 'heroes_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuest()
    {
        return $this->hasOne(Quest::className(), ['id' => 'quests_id']);
    }
}
