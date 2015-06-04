<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "heroes".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $hclass
 * @property string $hname
 * @property integer $hexp
 * @property string $hlevel
 * @property string $heroclassname
 * @property string $heroclassimg
 * @property array $heroskills
 *
 * @property User $user
 * @property QuestHero $questhero
 */
class Hero extends \yii\db\ActiveRecord
{
    // max level of heroes
    const MAX_LEVEL = 20;

    //hero class constants

    const HC_PALADIN = 0;
    const HC_ROGUE = 1;
    const HC_WIZARD = 2;
    const HC_WARLOCK = 3;


    public static function heroclassname_list()
    {
        return [
            self::HC_PALADIN => 'Паладін',
            self::HC_ROGUE => 'Характерник',
            self::HC_WIZARD => 'Чарівник',
            self::HC_WARLOCK => 'Демонолог',
        ];
    }

    private static function heroclassimg_list()
    {
        return [
            self::HC_PALADIN => '/img/heroes/paladin.jpg',
            self::HC_ROGUE => '/img/heroes/rogue.jpg',
            self::HC_WIZARD => '/img/heroes/wizard.jpg',
            self::HC_WARLOCK => '/img/heroes/warlock.jpg',
        ];
    }

    public function getHeroClassName()
    {
        return self::heroclassname_list()[$this->hclass];
    }

    public function getHeroClassImg()
    {
        return self::heroclassimg_list()[$this->hclass];
    }

    //skill bindings
    const HS_FIRST = 0;
    const HS_SECOND = 1;
    const HS_THIRD = 2;

    public static function heroskill_list()
    {
        return [
            self::HC_PALADIN => [
                self::HS_FIRST => Quest::O_DEMON_PORTAL,
                self::HS_SECOND => Quest::O_ORC_BAND,
                self::HS_THIRD => Quest::O_RISEN,
            ],
            self::HC_ROGUE => [
                self::HS_FIRST => Quest::O_DEMON_PORTAL,
                self::HS_SECOND => Quest::O_ANGEL_FIRE,
                self::HS_THIRD => Quest::O_ORC_BAND,
            ],
            self::HC_WIZARD => [
                self::HS_FIRST => Quest::O_ANGEL_FIRE,
                self::HS_SECOND => Quest::O_ORC_BAND,
                self::HS_THIRD => Quest::O_RISEN,
            ],
            self::HC_WARLOCK => [
                self::HS_FIRST => Quest::O_DEMON_PORTAL,
                self::HS_SECOND => Quest::O_ANGEL_FIRE,
                self::HS_THIRD => Quest::O_RISEN,
            ],
        ];
    }

    public static function heroskillname_list()
    {
        return [
            self::HC_PALADIN => [
                Quest::O_DEMON_PORTAL => 'Небесна блискавка',
                Quest::O_ORC_BAND => 'Льодяне коло',
                Quest::O_RISEN => 'Свята земля',
            ],
            self::HC_ROGUE => [
                Quest::O_DEMON_PORTAL => 'Фантомний заряд',
                Quest::O_ANGEL_FIRE => 'Гасіння',
                Quest::O_ORC_BAND => 'Страхітливий символ',
            ],
            self::HC_WIZARD => [
                Quest::O_ANGEL_FIRE => 'Льодяна могила',
                Quest::O_ORC_BAND => 'Магічний заряд',
                Quest::O_RISEN => 'Вогняний стовп',
            ],
            self::HC_WARLOCK => [
                Quest::O_DEMON_PORTAL => 'Слово влади',
                Quest::O_ANGEL_FIRE => 'Темний саван',
                Quest::O_RISEN => 'Кайдани душ',
            ],
        ];
    }

    public function getHeroSkills()
    {
        $skills = [];
        $skills[self::HS_FIRST] = [
            'id' => self::heroskill_list()[$this->hclass][self::HS_FIRST],
            'name' => self::heroskillname_list()[$this->hclass][self::heroskill_list()[$this->hclass][self::HS_FIRST]]
        ];
        if ($this->hlevel >= 10) {
            $skills[self::HS_SECOND] = [
                'id' => self::heroskill_list()[$this->hclass][self::HS_SECOND],
                'name' => self::heroskillname_list()[$this->hclass][self::heroskill_list()[$this->hclass][self::HS_SECOND]]
            ];
        }
        if ($this->hlevel >= 20) {
            $skills[self::HS_THIRD] = [
                'id' => self::heroskill_list()[$this->hclass][self::HS_THIRD],
                'name' => self::heroskillname_list()[$this->hclass][self::heroskill_list()[$this->hclass][self::HS_THIRD]]
            ];
        }
        return $skills;
    }

    public function isReady()
    {
        $ready = $this->questhero;
        if ($ready) {
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'heroes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'hclass', 'hexp', 'hlevel'], 'integer'],
            [['hname'], 'string', 'max' => 50],
            [['hname'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hclass' => 'Клас',
            'hname' => 'Ім\'я',
            'hexp' => 'Досвід',
            'hlevel' => 'Рівень',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuesthero()
    {
        return $this->hasOne(QuestHero::className(), ['heroes_id' => 'id']);
    }
}
