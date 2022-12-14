<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "report".
 *
 * @property integer $id
 * @property string $type
 * @property integer $truck_id
 * @property integer $trailer_id
 * @property integer $driver_id
 * @property integer $mileage
 * @property string $def_level
 * @property string $fuel_level
 * @property string $status
 * @property string $signature_file
 * @property string $signature_mime_type
 * @property string $signed_at
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property \common\models\Driver $driver
 * @property \common\models\Trailer $trailer
 * @property \common\models\Truck $truck
 * @property \common\models\ReportFlag[] $reportFlags
 * @property \common\models\ReportMedia[] $reportMedia
 * @property string $aliasModel
 */
abstract class Report extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report';
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
            [['type', 'driver_id', 'mileage', 'def_level', 'fuel_level', 'status'], 'required'],
            [['truck_id', 'trailer_id', 'driver_id', 'mileage'], 'default', 'value' => null],
            [['truck_id', 'trailer_id', 'driver_id', 'mileage'], 'integer'],
            [['signed_at'], 'safe'],
            [['type', 'def_level', 'fuel_level', 'status', 'signature_file', 'signature_mime_type'], 'string', 'max' => 255],
            [['driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Driver::className(), 'targetAttribute' => ['driver_id' => 'id']],
            [['trailer_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Trailer::className(), 'targetAttribute' => ['trailer_id' => 'id']],
            [['truck_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Truck::className(), 'targetAttribute' => ['truck_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'truck_id' => Yii::t('app', 'Truck ID'),
            'trailer_id' => Yii::t('app', 'Trailer ID'),
            'driver_id' => Yii::t('app', 'Driver ID'),
            'mileage' => Yii::t('app', 'Mileage'),
            'def_level' => Yii::t('app', 'Def Level'),
            'fuel_level' => Yii::t('app', 'Fuel Level'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'signature_file' => Yii::t('app', 'Signature File'),
            'signature_mime_type' => Yii::t('app', 'Signature Mime Type'),
            'signed_at' => Yii::t('app', 'Signed At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriver()
    {
        return $this->hasOne(\common\models\Driver::className(), ['id' => 'driver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrailer()
    {
        return $this->hasOne(\common\models\Trailer::className(), ['id' => 'trailer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTruck()
    {
        return $this->hasOne(\common\models\Truck::className(), ['id' => 'truck_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportFlags()
    {
        return $this->hasMany(\common\models\ReportFlag::className(), ['report_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReportMedia()
    {
        return $this->hasMany(\common\models\ReportMedia::className(), ['report_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'created_by']);
    }



}
