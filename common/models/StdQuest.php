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
 * @property StdBounty[] $mainBounty
 * $property StdBounty[] $bonusBounty
 */
class StdQuest extends \yii\db\ActiveRecord
{
    public $obstacles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'std_quest';
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

    public function getRewards()
    {
        return $this->hasMany(StdReward::className(), ['id' => 'id_stdreward'])->viaTable('std_questreward', ['id_quest' => 'id']);
    }

    public function getMainBounty()
    {
        return $this->hasMany(StdBounty::className(), ['id_stdquest' => 'id'])->andWhere(['type' => StdBounty::B_T_MAIN]);
    }

    public function getBonusBounty()
    {
        return $this->hasMany(StdBounty::className(), ['id_stdquest' => 'id'])->andWhere(['type' => StdBounty::B_T_BONUS]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        StdObstaclequest::deleteAll(['id_quest' => $this->id]);
        foreach ($this->obstacles as $obstacle) {
            StdObstaclequest::rel($obstacle, $this->id);
        }
        return parent::afterSave($insert, $changedAttributes);
    }

}