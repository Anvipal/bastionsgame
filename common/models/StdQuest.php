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
 * @property StdObstacle[] $idObstacles
 */
class StdQuest extends \yii\db\ActiveRecord
{
    public $obstacles;

    private function obstacle_line()
    {
        return '('.implode(',',$this->obstacles).')';
    }

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
            'title' => \Yii::t('common','STDQUEST_ATTR_TITLE'),
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

    /**
     * @return array
     */
    private function buildInsertFields()
    {
        $arr = [];
        foreach ($this->obstacles as $key)
        {
            $arr[] = '((select count(t.id)+1 from `std_obstaclequest` t where t.id_quest='.$this->id.'),'.$this->id.','.$key.')';
        }
        return $arr;
    }

    public function afterSave($insert, $changedAttributes){
        try {
            Yii::$app->db->createCommand('DELETE FROM `std_obstaclequest` WHERE `id_quest` = :id', [':id' => $this->id,])->execute();
            Yii::$app->db->createCommand('INSERT INTO `std_obstaclequest` (`id`,`id_quest`,`id_obstacle`) VALUES '.implode(',',$this->buildInsertFields()))->execute();
        }
        catch (Exception $e)
        {
            $this->delete();
            throw $e;
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
