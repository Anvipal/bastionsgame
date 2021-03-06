<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "std_obstaclehero".
 *
 * @property string $id_stdobstacle
 * @property string $id_stdhero
 * @property integer $slevel
 * @property integer $title
 * @property string $slevelTitle
 *
 * @property StdObstacle $idStdobstacle
 * @property StdHero $idStdhero
 */
class StdHeroSkill extends \yii\db\ActiveRecord
{
    const SK_FIRST = 0;
    const SK_SECOND = 1;
    const SK_THIRD = 2;

    public static function skilllevel_list($slevel = null)
    {
        $arr =  [
            self::SK_FIRST => Yii::t('common', 'STDHEROSKILL_SK_FIRST'),
            self::SK_SECOND => Yii::t('common', 'STDHEROSKILL_SK_SECOND'),
            self::SK_THIRD => Yii::t('common', 'STDHEROSKILL_SK_THIRD'),
        ];
        return isset($slevel) ? $arr[$slevel] : $arr;
    }

    public function getSlevelTitle()
    {
        return self::skilllevel_list($this->slevel);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'std_obstaclehero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_stdobstacle', 'id_stdhero', 'slevel', 'title'], 'required'],
            [['id_stdobstacle', 'id_stdhero', 'slevel'], 'integer'],
            [['title'], 'string', 'max' => 150],
            [['title'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_stdhero' => Yii::t('common', 'STDHERO_ATTR_CLASSNAME'),
            'id_stdobstacle' => Yii::t('common', 'STDOBSTACLE_ATTR_CLASSNAME'),
            'slevel' => Yii::t('common', 'STDHEROSKILL_ATTR_SLIVEL'),
            'title' => \Yii::t('common', 'STDHEROSKILL_ATTR_TITLE'),
            'slevelTitle' => Yii::t('common', 'STDHEROSKILL_ATTR_SLIVEL'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStdobstacle()
    {
        return $this->hasOne(StdObstacle::className(), ['id' => 'id_stdobstacle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStdhero()
    {
        return $this->hasOne(StdHero::className(), ['id' => 'id_stdhero']);
    }

    public function getIdHero()
    {
        return $this->hasOne(Hero::className(), ['id_stdhero' => 'id_stdhero']);
    }
}
