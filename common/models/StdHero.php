<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "std_heroes".
 *
 * @property string $id
 * @property string $name
 *
 * @property Heroes[] $heroes
 * @property StdObstaclehero[] $stdObstacleheroes
 * @property StdObstacles[] $idStdobstacles
 */
class StdHero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'std_heroes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeroes()
    {
        return $this->hasMany(Heroes::className(), ['id_stdhero' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStdObstacleheroes()
    {
        return $this->hasMany(StdObstaclehero::className(), ['id_stdhero' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStdobstacles()
    {
        return $this->hasMany(StdObstacles::className(), ['id' => 'id_stdobstacle'])->viaTable('std_obstaclehero', ['id_stdhero' => 'id']);
    }
}
