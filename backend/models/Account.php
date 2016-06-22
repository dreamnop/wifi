<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "account".
 *
 * @property string $username
 * @property string $password
 * @property string $firstname
 * @property string $lastname
 * @property string $card_id
 * @property string $address
 * @property string $mobile
 * @property string $dateregis
 * @property string $encryption
 * @property integer $status
 * @property integer $muney
 * @property integer $muney_total
 * @property string $exprie
 * @property string $login
 *
 * @property Radacct[] $radaccts
 * @property Radcheck[] $radchecks
 * @property Radcheck[] $radchecks0
 * @property Radpostauth[] $radpostauths
 * @property Radreply[] $radreplies
 * @property Radusergroup[] $radusergroups
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['dateregis'], 'safe'],
            [['status', 'muney', 'muney_total'], 'integer'],
            [['username', 'password'], 'string', 'max' => 64],
            [['firstname'], 'string', 'max' => 100],
            [['lastname'], 'string', 'max' => 150],
            [['card_id'], 'string', 'max' => 13],
            [['address'], 'string', 'max' => 200],
            [['mobile'], 'string', 'max' => 12],
            [['encryption'], 'string', 'max' => 10],
            [['exprie'], 'string', 'max' => 20],
            [['login'], 'string', 'max' => 1],
            [['username'], 'unique'],
            [['password'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'ชื่อผู้ใช้งาน',
            'password' => 'รหัสผ่าน',
            'firstname' => 'ชื่อ',
            'lastname' => 'นามสกุล',
            'card_id' => 'บัตรประชาชน',
            'address' => 'ที่อยู่',
            'mobile' => 'เบอร์โทรศัพท์',
            'dateregis' => 'วันที่สมัคร',
            'encryption' => 'Encryption',
            'status' => 'Status',
            'muney' => 'Muney',
            'muney_total' => 'Muney Total',
            'exprie' => 'วันหมดอายุ',
            'login' => 'Login',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRadaccts()
    {
        return $this->hasMany(Radacct::className(), ['username' => 'username']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRadchecks()
    {
        return $this->hasMany(Radcheck::className(), ['username' => 'username']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRadchecks0()
    {
        return $this->hasMany(Radcheck::className(), ['value' => 'password']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRadpostauths()
    {
        return $this->hasMany(Radpostauth::className(), ['username' => 'username']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRadreplies()
    {
        return $this->hasMany(Radreply::className(), ['username' => 'username']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRadusergroups()
    {
        return $this->hasMany(Radusergroup::className(), ['username' => 'username']);
    }
}
