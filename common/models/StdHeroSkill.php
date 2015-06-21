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
            [['id_stdobstacle', 'id_stdhero'], 'required'],
            [['id_stdobstacle', 'id_stdhero', 'slevel', 'title'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_stdobstacle' => 'Id Stdobstacle',
            'id_stdhero' => 'Id Stdhero',
            'slevel' => 'Slevel',
            'title' => 'Title',
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