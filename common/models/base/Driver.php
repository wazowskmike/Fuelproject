<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "driver".
 *
 * @property integer $id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property integer $state_id
 * @property string $zip
 * @property string $telephone
 * @property string $cell_phone
 * @property string $other_phone
 * @property integer $office_id
 * @property string $web_id
 * @property string $email_address
 * @property string $user_defined_1
 * @property string $user_defined_2
 * @property string $user_defined_3
 * @property string $social_sec_no
 * @property string $passport_no
 * @property string $passport_exp
 * @property string $date_of_birth
 * @property string $hire_date
 * @property boolean $mail_list
 * @property boolean $maintenance
 * @property string $notes
 * @property string $marked_as_down
 * @property string $type
 * @property integer $pay_to_vendor_id
 * @property integer $pay_to_driver_id
 * @property integer $pay_to_carrier_id
 * @property string $expense_acct
 * @property string $bank_acct
 * @property integer $co_driver_id
 * @property string $pay_standard
 * @property string $period_salary
 * @property string $hourly_rate
 * @property string $addl_ot_pay
 * @property string $addl_ot_pay_2
 * @property string $base_hours
 * @property string $pay_source
 * @property string $loaded_miles
 * @property string $empty_miles
 * @property string $loaded_pay_type
 * @property string $loaded_per_mile
 * @property string $empty_per_mile
 * @property string $percentage
 * @property string $status
 * @property integer $user_id
 * @property string $pay_frequency
 * @property string $co_driver_earning_percent
 * @property integer $updated_by
 * @property string $updated_at
 * @property integer $created_by
 * @property string $created_at
 *
 * @property \common\models\BillItem[] $billItems
 * @property \common\models\DispatchAssignment[] $dispatchAssignments
 * @property \common\models\DispatchAssignment[] $dispatchAssignments0
 * @property \common\models\Document[] $documents
 * @property \common\models\Account $expenseAcct
 * @property \common\models\Account $bankAcct
 * @property \common\models\Carrier $payToCarrier
 * @property \common\models\Driver $payToDriver
 * @property \common\models\Driver[] $drivers
 * @property \common\models\Driver $coDriver
 * @property \common\models\Driver[] $drivers0
 * @property \common\models\Office $office
 * @property \common\models\State $state
 * @property \common\models\User $user
 * @property \common\models\Vendor $payToVendor
 * @property \common\models\DriverAdjustment[] $driverAdjustments
 * @property \common\models\DriverAdjustment[] $driverAdjustments0
 * @property \common\models\DriverCompliance $driverCompliance
 * @property \common\models\DriverFuelCard[] $driverFuelCards
 * @property \common\models\FuelPurchase[] $fuelPurchases
 * @property \common\models\FuelPurchase[] $fuelPurchases0
 * @property \common\models\LoadDrop[] $loadDrops
 * @property \common\models\LoadDrop[] $loadDrops0
 * @property \common\models\LoadDrop[] $loadDrops1
 * @property \common\models\LoadDrop[] $loadDrops2
 * @property \common\models\LoadMovement[] $loadMovements
 * @property \common\models\Payroll[] $payrolls
 * @property \common\models\Payroll[] $payrolls0
 * @property \common\models\PayrollAdjustment[] $payrollAdjustments
 * @property \common\models\PayrollAdjustmentCode[] $payrollAdjustmentCodes
 * @property \common\models\Report[] $reports
 * @property \common\models\Trailer[] $trailers
 * @property \common\models\Truck[] $trucks
 * @property \common\models\Unit[] $units
 * @property \common\models\Unit[] $units0
 * @property string $aliasModel
 */
abstract class Driver extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'driver';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name', 'state_id', 'mail_list', 'maintenance'], 'required'],
            [['state_id', 'office_id', 'pay_to_vendor_id', 'pay_to_driver_id', 'pay_to_carrier_id', 'co_driver_id', 'user_id'], 'default', 'value' => null],
            [['state_id', 'office_id', 'pay_to_vendor_id', 'pay_to_driver_id', 'pay_to_carrier_id', 'co_driver_id', 'user_id'], 'integer'],
            [['passport_exp', 'date_of_birth', 'hire_date', 'marked_as_down'], 'safe'],
            [['mail_list', 'maintenance'], 'boolean'],
            [['notes'], 'string'],
            [['period_salary', 'hourly_rate', 'addl_ot_pay', 'addl_ot_pay_2', 'base_hours', 'loaded_per_mile', 'empty_per_mile', 'percentage', 'co_driver_earning_percent'], 'number'],
            [['last_name', 'first_name', 'middle_name', 'address_1', 'address_2', 'city', 'zip', 'telephone', 'cell_phone', 'other_phone', 'web_id', 'email_address', 'user_defined_1', 'user_defined_2', 'user_defined_3', 'social_sec_no', 'passport_no', 'type', 'expense_acct', 'bank_acct', 'pay_standard', 'pay_source', 'loaded_miles', 'empty_miles', 'loaded_pay_type', 'pay_frequency'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 25],
            [['user_id'], 'unique'],
            [['expense_acct'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Account::className(), 'targetAttribute' => ['expense_acct' => 'account']],
            [['bank_acct'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Account::className(), 'targetAttribute' => ['bank_acct' => 'account']],
            [['pay_to_carrier_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Carrier::className(), 'targetAttribute' => ['pay_to_carrier_id' => 'id']],
            [['pay_to_driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Driver::className(), 'targetAttribute' => ['pay_to_driver_id' => 'id']],
            [['co_driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Driver::className(), 'targetAttribute' => ['co_driver_id' => 'id']],
            [['office_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Office::className(), 'targetAttribute' => ['office_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\State::className(), 'targetAttribute' => ['state_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['pay_to_vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Vendor::className(), 'targetAttribute' => ['pay_to_vendor_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'last_name' => Yii::t('app', 'Last Name'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'address_1' => Yii::t('app', 'Address 1'),
            'address_2' => Yii::t('app', 'Address 2'),
            'city' => Yii::t('app', 'City'),
            'state_id' => Yii::t('app', 'State ID'),
            'zip' => Yii::t('app', 'Zip'),
            'telephone' => Yii::t('app', 'Telephone'),
            'cell_phone' => Yii::t('app', 'Cell Phone'),
            'other_phone' => Yii::t('app', 'Other Phone'),
            'office_id' => Yii::t('app', 'Office ID'),
            'web_id' => Yii::t('app', 'Web ID'),
            'email_address' => Yii::t('app', 'Email Address'),
            'user_defined_1' => Yii::t('app', 'User Defined 1'),
            'user_defined_2' => Yii::t('app', 'User Defined 2'),
            'user_defined_3' => Yii::t('app', 'User Defined 3'),
            'social_sec_no' => Yii::t('app', 'Social Sec No'),
            'passport_no' => Yii::t('app', 'Passport No'),
            'passport_exp' => Yii::t('app', 'Passport Exp'),
            'date_of_birth' => Yii::t('app', 'Date Of Birth'),
            'hire_date' => Yii::t('app', 'Hire Date'),
            'mail_list' => Yii::t('app', 'Mail List'),
            'maintenance' => Yii::t('app', 'Maintenance'),
            'notes' => Yii::t('app', 'Notes'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'marked_as_down' => Yii::t('app', 'Marked As Down'),
            'type' => Yii::t('app', 'Type'),
            'pay_to_vendor_id' => Yii::t('app', 'Pay To Vendor ID'),
            'pay_to_driver_id' => Yii::t('app', 'Pay To Driver ID'),
            'pay_to_carrier_id' => Yii::t('app', 'Pay To Carrier ID'),
            'expense_acct' => Yii::t('app', 'Expense Acct'),
            'bank_acct' => Yii::t('app', 'Bank Acct'),
            'co_driver_id' => Yii::t('app', 'Co Driver ID'),
            'pay_standard' => Yii::t('app', 'Pay Standard'),
            'period_salary' => Yii::t('app', 'Period Salary'),
            'hourly_rate' => Yii::t('app', 'Hourly Rate'),
            'addl_ot_pay' => Yii::t('app', 'Addl Ot Pay'),
            'addl_ot_pay_2' => Yii::t('app', 'Addl Ot Pay 2'),
            'base_hours' => Yii::t('app', 'Base Hours'),
            'pay_source' => Yii::t('app', 'Pay Source'),
            'loaded_miles' => Yii::t('app', 'Loaded Miles'),
            'empty_miles' => Yii::t('app', 'Empty Miles'),
            'loaded_pay_type' => Yii::t('app', 'Loaded Pay Type'),
            'loaded_per_mile' => Yii::t('app', 'Loaded Per Mile'),
            'empty_per_mile' => Yii::t('app', 'Empty Per Mile'),
            'percentage' => Yii::t('app', 'Percentage'),
            'status' => Yii::t('app', 'Status'),
            'user_id' => Yii::t('app', 'User ID'),
            'pay_frequency' => Yii::t('app', 'Pay Frequency'),
            'co_driver_earning_percent' => Yii::t('app', 'Co Driver Earning Percent'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillItems()
    {
        return $this->hasMany(\common\models\BillItem::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDispatchAssignments()
    {
        return $this->hasMany(\common\models\DispatchAssignment::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDispatchAssignments0()
    {
        return $this->hasMany(\common\models\DispatchAssignment::className(), ['codriver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(\common\models\Document::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseAcct()
    {
        return $this->hasOne(\common\models\Account::className(), ['account' => 'expense_acct']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBankAcct()
    {
        return $this->hasOne(\common\models\Account::className(), ['account' => 'bank_acct']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayToCarrier()
    {
        return $this->hasOne(\common\models\Carrier::className(), ['id' => 'pay_to_carrier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayToDriver()
    {
        return $this->hasOne(\common\models\Driver::className(), ['id' => 'pay_to_driver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrivers()
    {
        return $this->hasMany(\common\models\Driver::className(), ['pay_to_driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoDriver()
    {
        return $this->hasOne(\common\models\Driver::className(), ['id' => 'co_driver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrivers0()
    {
        return $this->hasMany(\common\models\Driver::className(), ['co_driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffice()
    {
        return $this->hasOne(\common\models\Office::className(), ['id' => 'office_id']);
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
    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayToVendor()
    {
        return $this->hasOne(\common\models\Vendor::className(), ['id' => 'pay_to_vendor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriverAdjustments()
    {
        return $this->hasMany(\common\models\DriverAdjustment::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriverAdjustments0()
    {
        return $this->hasMany(\common\models\DriverAdjustment::className(), ['post_to_driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriverCompliance()
    {
        return $this->hasOne(\common\models\DriverCompliance::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriverFuelCards()
    {
        return $this->hasMany(\common\models\DriverFuelCard::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFuelPurchases()
    {
        return $this->hasMany(\common\models\FuelPurchase::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFuelPurchases0()
    {
        return $this->hasMany(\common\models\FuelPurchase::className(), ['codriver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoadDrops()
    {
        return $this->hasMany(\common\models\LoadDrop::className(), ['drop_driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoadDrops0()
    {
        return $this->hasMany(\common\models\LoadDrop::className(), ['drop_codriver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoadDrops1()
    {
        return $this->hasMany(\common\models\LoadDrop::className(), ['retrieve_driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoadDrops2()
    {
        return $this->hasMany(\common\models\LoadDrop::className(), ['retrieve_codriver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoadMovements()
    {
        return $this->hasMany(\common\models\LoadMovement::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayrolls()
    {
        return $this->hasMany(\common\models\Payroll::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayrolls0()
    {
        return $this->hasMany(\common\models\Payroll::className(), ['pay_to_driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayrollAdjustments()
    {
        return $this->hasMany(\common\models\PayrollAdjustment::className(), ['d_post_to_driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayrollAdjustmentCodes()
    {
        return $this->hasMany(\common\models\PayrollAdjustmentCode::className(), ['post_to_driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(\common\models\Report::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrailers()
    {
        return $this->hasMany(\common\models\Trailer::className(), ['owned_by_driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrucks()
    {
        return $this->hasMany(\common\models\Truck::className(), ['owned_by_driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasMany(\common\models\Unit::className(), ['driver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnits0()
    {
        return $this->hasMany(\common\models\Unit::className(), ['co_driver_id' => 'id']);
    }




}
