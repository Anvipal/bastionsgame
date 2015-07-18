<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "std_reward".
 *
 * @property string $id
 * @property string $name
 * @property integer $type
 *
 * @property StdQuest[] $idStdquests
 */
class StdReward extends \yii\db\ActiveRecord
{

    const R_T_GOLD = 1;
    const R_T_EXP = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'std_reward';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
            'type' => 'Type',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStdquests()
    {
        return $this->hasMany(StdQuest::className(), ['id' => 'id_stdquest'])->viaTable('std_questreward', ['id_stdreward' => 'id']);
    }

    public function useReward()
    {

    }
}
