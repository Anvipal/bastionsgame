<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quests".
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $desc
 * @property string $midhlevel
 * @property string $hcnt
 * @property string $chance
 * @property integer $timetodo
 * @property integer $timestart
 * @property integer $status
 * @property string $stdquests_id
 *
 * @property StdQuests $stdquests
 * @property Users $user
 * @property Questsheroes[] $questsheroes
 */
class Quest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'midhlevel', 'hcnt', 'chance', 'timetodo', 'timestart', 'status', 'stdquests_id'], 'integer'],
            [['desc'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'midhlevel' => 'Midhlevel',
            'hcnt' => 'Hcnt',
            'chance' => 'Chance',
            'timetodo' => 'Timetodo',
            'timestart' => 'Timestart',
            'status' => 'Status',
            'stdquests_id' => 'Stdquests ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStdquests()
    {
        return $this->hasOne(StdQuests::className(), ['id' => 'stdquests_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestsheroes()
    {
        return $this->hasMany(Questsheroes::className(), ['quests_id' => 'id']);
    }
}
