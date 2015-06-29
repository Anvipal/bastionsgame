<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "quests".
 *
 * @property string $id
 * @property string $id_user
 * @property string $midhlevel
 * @property string $chance
 * @property integer $timestart
 * @property integer $status
 * @property string $id_stdquests
 *
 * @property StdQuest $idStdquest
 * @property User $user
 * @property StdObstacle $obstacles
 * @property Hero[] $heroes
 */
class Quest extends \yii\db\ActiveRecord
{
    private $hero_cnt;

    const MAX_QUESTS = 4;

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
            [['id_user'], 'required'],
            [['id_user', 'midhlevel', 'chance', 'timestart', 'status', 'id_stdquests'], 'integer'],
            [['hero_cnt'], 'default', 'value' => $this->idStdquest->hcnt],
            [['hero_cnt'], 'compare', 'compareAttribute' => count($this->heroes->all())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'User ID',
            'midhlevel' => 'Midhlevel',
            'chance' => 'Chance',
            'timetodo' => 'Timetodo',
            'timestart' => 'Timestart',
            'status' => 'Status',
            'id_stdquests' => 'Stdquests ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStdquest()
    {
        return $this->hasOne(StdQuest::className(), ['id' => 'id_stdquests']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
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

    public static function userQuestUpdate()
    {
        $users = User::find()->select(['id'])->all();
        foreach ($users as $user) {
            /* @var $user User */
            $existing = Quest::find()->select(['id', 'id_stdquests'])->andWhere(['id_user' => $user->id])->asArray()->all();
            if (count($existing) < self::MAX_QUESTS) {
                $newquests = StdQuest::find()->select(['id'])->andOnCondition(['NOT IN', 'id', array_values(ArrayHelper::map($existing, 'id', 'is_stdquests'))])->all();
                $newquests = array_rand($newquests, self::MAX_QUESTS - count($existing));
                foreach ($newquests as $newquest) {
                    /* @var $newquest StdQuest */
                    $newQuest = new Quest();
                    $newQuest->id_stdquests = $newquest->id;
                    $newQuest->id_user = $user->id;
                    $newQuest->status = self::ST_NEW;
                    $newQuest->save();
                }
            }
        }
    }

}
