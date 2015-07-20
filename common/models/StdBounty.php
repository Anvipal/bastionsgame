<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "std_questreward".
 *
 * @property string $id_stdquest
 * @property string $id_stdreward
 * @property integer $cnt
 *
 * @property StdQuest $idStdquest
 * @property StdReward $idStdreward
 */
class StdBounty extends \yii\db\ActiveRecord
{
    const B_T_MAIN = 1;
    const B_T_BONUS = 2;

    public static function type_list($type = null){
        $arr = [
            self::B_T_MAIN => Yii::t('common', 'STDBOUNTY_BT_MAIN'),
            self::B_T_BONUS => Yii::t('common', 'STDBOUNTY_BT_BONUS'),
        ];
        return isset($type) ? $arr[$type] : $arr;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'std_questreward';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_stdquest', 'id_stdreward', 'cnt', 'type'], 'required'],
            [['id_stdquest', 'id_stdreward', 'cnt', 'type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_stdquest' => 'Id Stdquest',
            'id_stdreward' => 'Id Stdreward',
            'cnt' => 'Cnt',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStdquest()
    {
        return $this->hasOne(StdQuest::className(), ['id' => 'id_stdquest']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStdreward()
    {
        return $this->hasOne(StdReward::className(), ['id' => 'id_stdreward']);
    }
}
