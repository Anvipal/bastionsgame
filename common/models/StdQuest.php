<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "std_quests".
 *
 * @property string $id
 * @property string $name
 * @property string $desc
 * @property string $midhlevel
 * @property string $hcnt
 * @property integer $obscales
 * @property integer $timetodo
 *
 * @property Quest[] $quests
 * @property StdObstacle[] $idObstacles
 */
class StdQuest extends \yii\db\ActiveRecord
{
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
            [['midhlevel', 'hcnt', 'obscales', 'timetodo'], 'integer'],
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
            'name' => \Yii::t('common','STDQUEST_ATTR_NAME'),
            'desc' => \Yii::t('common','STDQUEST_ATTR_DESCRIPTION'),
            'midhlevel' => \Yii::t('common','STDQUEST_ATTR_MIDLEVEL'),
            'timetodo' => \Yii::t('common','STDQUEST_ATTR_TIMETODO'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuests()
    {
        return $this->hasMany(Quest::className(), ['stdquests_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdObstacles()
    {
        return $this->hasMany(StdObstacle::className(), ['id' => 'id_obstacle'])->viaTable('std_obstaclequest', ['id_quest' => 'id']);
    }
}
