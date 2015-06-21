<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "heroes".
 *
 * @property string $id
 * @property string $id_user
 * @property string $id_stdhero
 * @property string $title
 * @property string $hexp
 * @property string $hlevel
 *
 * @property User $idUser
 * @property StdHero $idStdhero
 */
class Hero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'heroes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_stdhero', 'hexp', 'hlevel'], 'integer'],
            [['title'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_stdhero' => 'Id Stdhero',
            'title' => 'Title',
            'hexp' => 'Hexp',
            'hlevel' => 'Hlevel',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStdhero()
    {
        return $this->hasOne(StdHero::className(), ['id' => 'id_stdhero']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestsheroes()
    {
        return $this->hasOne(Questsheroes::className(), ['heroes_id' => 'id']);
    }

    public function getQuest()
    {
        return $this->hasOne(Quest::className(),['id' => 'id_quest'])->viaTable('questheroes', ['id_hero' => 'id']);
    }
}
