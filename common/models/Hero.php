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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'heroes';
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
            'id' => 'ID',
            'id_stdhero' => \Yii::t('common','STDHERO_ATTR_NAME'),
            'title' => \Yii::t('common','HERO_ATTR_TITLE'),
            'hexp' => \Yii::t('common','HERO_ATTR_EXP'),
            'hlevel' => \Yii::t('common','HERO_LEVEL'),
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->skillCount > 0)
        {
            $skills = StdHeroSkill::find()->andWhere(['id_stdhero' => $this->id_stdhero])->andWhere(['NOT IN','id_stdobstacle',ArrayHelper::map($this->idSkills,'id_obstacke','id_obstacke')])->asArray()->all();
            if (count($skills) > 0)
            {
                $i = rand(0,count($skills)-1);

            }
        }
        return parent::beforeSave($insert);
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
        return $this->hasOne(Quest::className(),['id' => 'id_quest'])->viaTable('questsheroes', ['id_hero' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSkills()
    {
        return $this->idStdhero->idStdSkills;
    }

    private function getSkillCount()
    {
        return ($this->hlevel / 10) + 1 - count($this->idSkills);
    }
}
