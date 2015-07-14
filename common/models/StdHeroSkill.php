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
 *
 * @property StdObstacle $idStdobstacle
 * @property StdHero $idStdhero
 */
class StdHeroSkill extends \yii\db\ActiveRecord
{
    const SK_FIRST = 0;
    const SK_SECOND = 1;
    const SK_THIRD = 2;

    public static function skilllevel_list()
    {
        return [
            self::SK_FIRST => Yii::t('common','STDHEROSKILL_SK_FIRST'),
            self::SK_SECOND => Yii::t('common','STDHEROSKILL_SK_SECOND'),
            self::SK_THIRD => Yii::t('common','STDHEROSKILL_SK_THIRD'),
        ];
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
            [['id_stdobstacle', 'id_stdhero', 'slevel'], 'required'],
            [['id_stdobstacle', 'id_stdhero', 'slevel'], 'integer'],
            [['title'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_stdhero' => Yii::t('common','STDHERO_ATTR_CLASSNAME'),
            'id_stdobstacle' => Yii::t('common','STDOBSTACLE_ATTR_CLASSNAME'),
            'slevel' => Yii::t('common','STDHEROSKILL_ATTR_SLIVEL'),
            'title' => \Yii::t('common','STDHEROSKILL_ATTR_TITLE'),
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
}
