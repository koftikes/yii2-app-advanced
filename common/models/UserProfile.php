<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $user_id
 * @property string $name
 * @property string $phone
 * @property integer $gender
 * @property string $DOB
 * @property integer $subscribe
 * @property string $info
 *
 * @property User $user
 */
class UserProfile extends ActiveRecord
{
    const GENDER_THING = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    const SUBSCRIBE_NOT_ACTIVE = 0;
    const SUBSCRIBE_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender', 'subscribe'], 'integer'],
            ['DOB', 'default', 'value' => null],
            ['DOB', 'date', 'format' => 'yyyy-mm-dd'],
            [['DOB'], 'safe'],
            [['info'], 'string'],
            [['name', 'phone'], 'string', 'max' => 255],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_id' => 'id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('common', 'Full Name'),
            'phone' => Yii::t('common', 'Phone'),
            'gender' => Yii::t('common', 'Gender'),
            'DOB' => Yii::t('common', 'DOB'),
            'subscribe' => Yii::t('common', 'Subscribe'),
            'info' => Yii::t('common', 'Info'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
