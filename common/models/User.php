<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $email
 * @property string $name
 * @property string $pwdhash
 * @property string $salt
 * @property string $goldcnt
 *
 * @property Hero[] $heroes
 * @property Quest[] $quests
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goldcnt'], 'integer'],
            [['email', 'name'], 'string', 'max' => 255],
            [['pwdhash', 'salt'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'pwdhash' => 'Pwdhash',
            'salt' => 'Salt',
            'goldcnt' => 'Goldcnt',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeroes()
    {
        return $this->hasMany(Hero::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuests()
    {
        return $this->hasMany(Quest::className(), ['user_id' => 'id']);
    }
}
