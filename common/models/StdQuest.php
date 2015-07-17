<?php

namespace common\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\db\QueryBuilder;

/**
 * This is the model class for table "std_quests".
 *
 * @property string $id
 * @property string $title
 * @property string $desc
 * @property string $midhlevel
 * @property string $hcnt
 * @property integer $timetodo
 *
 * @property Quest[] $quests
 * @property StdObstaclequest[] $idObstaclequest
 */
class StdQuest extends \yii\db\ActiveRecord
{
    public $obstacles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'std_quests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desc'], 'string'],
            [['midhlevel', 'hcnt', 'timetodo'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['title'], 'required'],
            [['obstacles'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => \Yii::t('common', 'STDQUEST_ATTR_TITLE'),
            'desc' => \Yii::t('common', 'STDQUEST_ATTR_DESCRIPTION'),
            'midhlevel' => \Yii::t('common', 'STDQUEST_ATTR_MIDLEVEL'),
            'timetodo' => \Yii::t('common', 'STDQUEST_ATTR_TIMETODO'),
            'hcnt' => Yii::t('common', 'STDQUEST_ATTR_HCNT'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuests()
    {
        return $this->hasMany(Quest::className(), ['stdquests_id' => 'id']);
    }

    public function getIdObstaclequest()
    {
        return $this->hasMany(StdObstaclequest::className(), ['id_quest' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        StdObstaclequest::deleteAll(['id_quest' => $this->id]);
        foreach ($this->obstacles as $obstacle) {
            $obs = null;
            if (!$obs = StdObstaclequest::findOne(['id_quest' => $this->id, 'id_obstacle' => $obstacle])) {
                $obs = new StdObstaclequest();
                $obs->id_obstacle = $obstacle;
                $obs->id_quest = $this->id;
                $obs->cnt = 0;
            }
            $obs->cnt += 1;
            $obs->save();
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
