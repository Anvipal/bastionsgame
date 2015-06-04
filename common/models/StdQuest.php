<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "std_quests".
 *
 * @property string $id
 * @property string $name
 * @property string $desc
 * @property string $midhlevel
 * @property string $hcnt
 * @property integer $obscales
 * @property integer $timetodo
 *
 * @property Quest[] $quests
 */
class StdQuest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'std_quests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desc'], 'string'],
            [['midhlevel', 'hcnt', 'obscales', 'timetodo'], 'integer'],
            [['name'], 'string', 'max' => 255]
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
            'desc' => 'Desc',
            'midhlevel' => 'Midhlevel',
            'hcnt' => 'Hcnt',
            'obscales' => 'Obscales',
            'timetodo' => 'Timetodo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuest()
    {
        return $this->hasMany(Quest::className(), ['stdquests_id' => 'id']);
    }
}
