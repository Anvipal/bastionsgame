<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "std_heroes".
 *
 * @property string $id
 * @property string $name
 *
 * @property Hero[] $heroes
 * @property StdObstacle[] $idStdobstacles
 * @property StdHeroSkill[] $idStdSkills
 * @property array $heroSkillLevels
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



    public function getHeroSkillLevels()
    {
        return ArrayHelper::map($this->getIdStdSkills()->select(['slevel'])->all(),'slevel','slevel');
    }

    public function getSkillLevelAvailable($slevel = null)
    {
        $arr = StdHeroSkill::skilllevel_list();
        foreach ($this->getHeroSkillLevels() as $val)
        {
            if (!(isset($slevel) && $val == $slevel))unset($arr[$val]);
        }
        return $arr;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'unique'],
            [['name'], 'required'],
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
            'name' => Yii::t('common','STDHERO_ATTR_NAME'),//'Клас',
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
