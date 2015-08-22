<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "std_obstaclequest".
 *
 * @property integer $id_obstacle
 * @property integer $id_quest
 * @property integer $cnt
 *
 * @property StdObstacle $idObstacle
 * @property StdQuest $idQuest
 */
class StdObstaclequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'std_obstaclequest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_obstacle', 'id_quest'], 'required'],
            [['id_obstacle', 'id_quest', 'cnt'], 'integer'],
            [['cnt'], 'default', 'value' => 0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_obstacle' => 'Id Obstacle',
            'id_quest' => 'Id Quest',
            'cnt' => 'Cnt',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdObstacle()
    {
        return $this->hasOne(StdObstacle::className(), ['id' => 'id_obstacle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdQuest()
    {
        return $this->hasOne(StdQuest::className(), ['id' => 'id_quest']);
    }

    /**
     * @param $id_o integer
     * @param $id_q integer
     * @return bool
     */
    public static function rel($id_o, $id_q){
        $model = self::findOne(['id_quest' => $id_q, 'id_obstacle' => $id_o]);
        $model = $model ?: new self;
        $model->cnt += 1;
        return $model->save();
    }
}
