<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "std_heroes".
 *
 * @property string $id
 * @property string $name
 *
 * @property Hero[] $heroes
 * @property StdObstacle[] $idStdobstacles
 * @property StdHeroSkill[] $idStdSkills
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
        return $this->hasMany(Hero::className(), ['id_stdhero' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStdobstacles()
    {
        return $this->hasMany(StdObstacle::className(), ['id' => 'id_stdobstacle'])->viaTable('std_obstaclehero', ['id_stdhero' => 'id']);
    }

    public function getIdStdSkills()
    {
        return $this->hasMany(StdHeroSkill::className(), ['id_stdhero' => 'id']);
    }
}
