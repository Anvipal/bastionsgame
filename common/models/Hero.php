<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "heroes".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_stdhero
 * @property string $title
 * @property integer $hexp
 * @property integer $hlevel
 * @property integer $skillCount
 *
 * @property User $idUser
 * @property StdHero $idStdhero
 * @property Quest $idQuest
 * @property StdHeroSkill[] $idSkills
 */
class Hero extends \yii\db\ActiveRecord
{
    const MAX_HERO_LEVEL = 20;
    const BASE_EXP = 1000;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hero';
    }

    /**
     * @return \yii\db\ActiveQuery|static
     */
    public static function find()
    {
        return parent::find()->andWhere(['id_user' => 1]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_stdhero', 'title'], 'required'],
            [['id_user', 'id_stdhero', 'hexp', 'hlevel'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['title'], 'unique', 'targetAttribute' => ['title', 'id_user']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_stdhero' => \Yii::t('common', 'STDHERO_ATTR_NAME'),
            'title' => \Yii::t('common', 'HERO_ATTR_TITLE'),
            'hexp' => \Yii::t('common', 'HERO_ATTR_EXP'),
            'hlevel' => \Yii::t('common', 'HERO_LEVEL'),
            'idSkills' => Yii::t('common', 'STDHEROSKILL_ATTR_CLASSNAME')
        ];
    }

    public function addExp($exp)
    {
        if (is_numeric($exp)) {
            if ($this->hlevel < self::MAX_HERO_LEVEL) {
                $this->hexp += $exp;
                if ($this->hexp > self::BASE_EXP * $this->hlevel * $this->hlevel) {
                    $this->levelUp();
                }
            }
        }
    }

    public function levelUp()
    {
        $this->hlevel += 1;
        $this->hexp -= self::BASE_EXP * pow($this->hlevel - 1, 2);
        $this->save(false);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStdhero()
    {
        return $this->hasOne(StdHero::className(), ['id' => 'id_stdhero']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdQuest()
    {
        return $this->hasOne(Quest::className(), ['id' => 'id_quest'])->viaTable('questsheroes', ['id_hero' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSkills()
    {
        return StdHeroSkill::find()->joinWith('idHero')->andWhere('(`std_obstaclehero`.`slevel` < (`heroes`.`hlevel` DIV 10)+1)')->orderBy(['slevel' => SORT_ASC])->all();
    }

}
