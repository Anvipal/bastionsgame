<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "std_obstacles".
 *
 * @property string $id
 * @property string $title
 *
 * @property StdObstaclehero[] $stdObstacleheroes
 * @property StdHeroes[] $idStdheroes
 * @property StdObstaclequest[] $stdObstaclequests
 * @property StdQuests[] $idQuests
 */
class StdObstacle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'std_obstacles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStdObstacleheroes()
    {
        return $this->hasMany(StdObstaclehero::className(), ['id_stdobstacle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStdheroes()
    {
        return $this->hasMany(StdHeroes::className(), ['id' => 'id_stdhero'])->viaTable('std_obstaclehero', ['id_stdobstacle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStdObstaclequests()
    {
        return $this->hasMany(StdObstaclequest::className(), ['id_obstacle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdQuests()
    {
        return $this->hasMany(StdQuests::className(), ['id' => 'id_quest'])->viaTable('std_obstaclequest', ['id_obstacle' => 'id']);
    }
}
