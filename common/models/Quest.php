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
 * @property StdQuest $idStdquest
 * @property User $user
 * @property StdObstacle $obstacles
 */
class Quest extends \yii\db\ActiveRecord
{
    const ST_NEW = 0;
    const ST_IN_PROCESS = 1;
    const ST_DONE = 2;

    public static function statuslist()
    {
        return [
            self::ST_NEW => 'Нове',
            self::ST_IN_PROCESS => 'Виконується',
            self::ST_DONE => 'Завершено',
        ];
    }

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
    public function getIdStdquest()
    {
        return $this->hasOne(StdQuest::className(), ['id' => 'stdquests_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeroes()
    {
        return $this->hasMany(Hero::className(), ['id' => 'id_hero'])->viaTable('questsheroes', ['id_quest' => 'id']);
    }
    /**
     * @return \common\models\StdObstacle[]
     */
    public function getObstacles()
    {
        return $this->idStdquest->idObstacles;
    }

}
