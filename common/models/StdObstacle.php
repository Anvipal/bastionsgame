<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "std_obstacles".
 *
 * @property string $id
 * @property string $title
 *
 * @property StdHeroSkill[] $idHeroskills
 * @property StdHero[] $idStdheroes
 * @property StdQuest[] $idQuests
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
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['title'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('common','STDOBSTACLE_ATTR_TITLE'),//'Назва',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdHeroskills()
    {
        return $this->hasMany(StdHeroSkill::className(), ['id_stdobstacle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStdheroes()
    {
        return $this->hasMany(StdHero::className(), ['id' => 'id_stdhero'])->viaTable('std_obstaclehero', ['id_stdobstacle' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdQuests()
    {
        return $this->hasMany(StdQuest::className(), ['id' => 'id_quest'])->viaTable('std_obstaclequest', ['id_obstacle' => 'id']);
    }
}
