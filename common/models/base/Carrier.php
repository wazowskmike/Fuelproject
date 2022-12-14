<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;

/**
 * This is the base-model class for table "carrier".
 *
 * @property integer $id
 * @property string $notes
 * @property string $special_instructions
 * @property string $name
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property integer $state_id
 * @property string $zip
 * @property string $main_phone
 * @property string $main_800
 * @property string $main_fax
 * @property string $email
 * @property string $website
 * @property string $disp_contact
 * @property string $ar_contact
 * @property string $other_contact
 * @property string $account_no
 * @property string $federal_id
 * @property boolean $mail_list
 * @property string $marked_as_down
 *
 * @property \common\models\State $state
 * @property \common\models\CarrierContact[] $carrierContacts
 * @property \common\models\CarrierContactNote[] $carrierContactNotes
 * @property \common\models\CarrierProfile $carrierProfile
 * @property \common\models\Document[] $documents
 * @property \common\models\Driver[] $drivers
 * @property \common\models\LanePreference $lanePreference
 * @property \common\models\Truck[] $trucks
 * @property string $aliasModel
 */
abstract class Carrier extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carrier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notes', 'special_instructions'], 'string'],
            [['name', 'mail_list'], 'required'],
            [['state_id'], 'default', 'value' => null],
            [['state_id'], 'integer'],
            [['mail_list'], 'boolean'],
            [['marked_as_down'], 'safe'],
            [['name', 'address_1', 'address_2', 'city', 'main_phone', 'main_800', 'main_fax', 'email', 'website', 'disp_contact', 'ar_contact', 'other_contact', 'account_no', 'federal_id'], 'string', 'max' => 255],
            [['zip'], 'string', 'max' => 10],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\State::className(), 'targetAttribute' => ['state_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'notes' => Yii::t('app', 'Notes'),
            'special_instructions' => Yii::t('app', 'Special Instructions'),
            'name' => Yii::t('app', 'Name'),
            'address_1' => Yii::t('app', 'Address 1'),
            'address_2' => Yii::t('app', 'Address 2'),
            'city' => Yii::t('app', 'City'),
            'state_id' => Yii::t('app', 'State ID'),
            'zip' => Yii::t('app', 'Zip'),
            'main_phone' => Yii::t('app', 'Main Phone'),
            'main_800' => Yii::t('app', 'Main 800'),
            'main_fax' => Yii::t('app', 'Main Fax'),
            'email' => Yii::t('app', 'Email'),
            'website' => Yii::t('app', 'Website'),
            'disp_contact' => Yii::t('app', 'Disp Contact'),
            'ar_contact' => Yii::t('app', 'Ar Contact'),
            'other_contact' => Yii::t('app', 'Other Contact'),
            'account_no' => Yii::t('app', 'Account No'),
            'federal_id' => Yii::t('app', 'Federal ID'),
            'mail_list' => Yii::t('app', 'Mail List'),
            'marked_as_down' => Yii::t('app', 'Marked As Down'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(\common\models\State::className(), ['id' => 'state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarrierContacts()
    {
        return $this->hasMany(\common\models\CarrierContact::className(), ['carrier_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarrierContactNotes()
    {
        return $this->hasMany(\common\models\CarrierContactNote::className(), ['carrier_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarrierProfile()
    {
        return $this->hasOne(\common\models\CarrierProfile::className(), ['carrier_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(\common\models\Document::className(), ['carrier_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrivers()
    {
        return $this->hasMany(\common\models\Driver::className(), ['pay_to_carrier_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanePreference()
    {
        return $this->hasOne(\common\models\LanePreference::className(), ['carrier_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrucks()
    {
        return $this->hasMany(\common\models\Truck::className(), ['owned_by_carrier_id' => 'id']);
    }




}
