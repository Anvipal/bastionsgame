<?php

namespace common\models;

use Yii;
use yii\base\Exception;

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
 * @property integer $obscales
 * @property integer $timetodo
 * @property integer $timestart
 * @property integer $status
 * @property string $statusname
 * @property integer $stdquests_id
 * @property bool $isNew
 *
 * @property User $user
 * @property QuestHero[] $questsheroes
 */
class Quest extends \yii\db\ActiveRecord
{
    const MAX_QUESTS = 4;

    const O_DEMON_PORTAL = 0;
    const O_ANGEL_FIRE = 1;
    const O_ORC_BAND = 2;
    const O_RISEN = 3;

    public static function obscalename_list()
    {
        return [
            self::O_DEMON_PORTAL => ['code' => 0b0001, 'name' => 'Портал демонів'],
            self::O_ANGEL_FIRE => ['code' => 0b0010, 'name' => 'Ангельске полум\'я'],
            self::O_ORC_BAND => ['code' => 0b0100, 'name' => 'Ватага орків'],
            self::O_RISEN => ['code' => 0b1000, 'name' => 'Повсталі мерці'],
        ];
    }

    const ST_NEW = 0;
    const ST_IN_PROCESS = 1;
    const ST_DONE = 2;

    public static function status_list()
    {
        return [
            self::ST_NEW => 'Нове',
            self::ST_IN_PROCESS => 'Виконується',
            self::ST_DONE => 'Завершено',
        ];
    }

    public function getStatusName()
    {
        return self::status_list()[$this->status];
    }

    public function getIsNew()
    {
        return $this->status == self::ST_NEW;
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
            [['user_id', 'stdquests_id'], 'required'],
            [['user_id', 'stdquests_id', 'midhlevel', 'hcnt', 'chance', 'obscales', 'timetodo', 'timestart', 'status'], 'integer'],
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
            'name' => 'Назва',
            'desc' => 'Опис',
            'midhlevel' => 'Середній рівень',
            'hcnt' => 'Hcnt',
            'chance' => 'Успіх',
            'obscales' => 'Перекшоди',
            'timetodo' => 'Час виконання',
            'timestart' => 'Timestart',
            'status' => 'Статус',
        ];
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
    public function getQuesthero()
    {
        return $this->hasMany(QuestHero::className(), ['quests_id' => 'id']);
    }

    public function getStdquest()
    {
        return $this->hasOne(StdQuest::className(), ['id' => 'stdquests_id']);
    }


    public static function userquestupdate()
    {
        $users = User::find()->all();
        foreach ($users as $user) {
            $quests_cnt = Quest::find()
                ->where(['status' => Quest::ST_NEW])
                ->orWhere(['status' => Quest::ST_IN_PROCESS])
                ->count();
            $quests_cnt = self::MAX_QUESTS - $quests_cnt;
            if (intval($quests_cnt) && $quests_cnt > 0) {
                $used_quests = self::find()
                    ->select('stdquests_id')
                    ->where('status in (:p1, :p2)', [':p1' => self::ST_IN_PROCESS, ':p2' => self::ST_NEW])
                    ->all();
                $std_quests = StdQuest::find()
                    ->select('id')
                    ->where('id not in (' . implode(',', $used_quests) . ')')
                    ->all();
                $new_quests_indexes = array_rand($std_quests, $quests_cnt);
                for ($i = 0; $i < count($new_quests_indexes); $i++) {
                    $newq = new Quest();
                    $newq->name = $std_quests[$new_quests_indexes[$i]]->name;
                    $newq->desk = $std_quests[$new_quests_indexes[$i]]->desk;
                    $newq->midhlevel = $std_quests[$new_quests_indexes[$i]]->midhlevel;
                    $newq->hcnt = $std_quests[$new_quests_indexes[$i]]->hcnt;
                    $newq->obscales = $std_quests[$new_quests_indexes[$i]]->obscales;
                    $newq->timetodo = $std_quests[$new_quests_indexes[$i]]->timetodo;
                    $newq->stdquests_id = $std_quests[$new_quests_indexes[$i]]->id;
                    $newq->user_id = $user->id;
                    $newq->status = self::ST_NEW;
                    if (!$newq->save()) {
                        throw new Exception('Помилка оновлення завдань');
                    }
                }
            }
        }
    }
}
