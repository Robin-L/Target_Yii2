<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;

/**
 * This is the model class for table "carousel_settings".
 *
 * @property integer $id
 * @property string $carousel_name
 * @property string $image_height
 * @property string $image_width
 * @property integer $carousel_autoplay
 * @property integer $show_indicators
 * @property integer $show_caption_title
 * @property integer $show_captions
 * @property integer $show_caption_background
 * @property string $caption_font_size
 * @property integer $show_controls
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Status $status
 */
class CarouselSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carousel_settings';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['carousel_name', 'image_height', 'image_width', 'caption_font_size', 'status_id'], 'required'],
            [['carousel_autoplay', 'show_indicators', 'show_captions', 'show_controls', 'status_id'], 'integer'],
            [['carousel_autoplay'], 'in', 'range' => array_keys($this->getCarouselAutoplayList())],
            [['show_indicators'], 'in', 'range' => array_keys($this->getShowIndicatorsList())],
            [['show_captions'], 'in', 'range' => array_keys($this->getShowCaptionsList())],
            [['show_caption_background'], 'in', 'range' => array_keys($this->getShowCaptionBackgroundList())],
            [['show_caption_title'], 'in', 'range' => array_keys($this->getShowCaptionTitleList())],
            [['show_controls'], 'in', 'range' => array_keys($this->getShowControlsList())],
            [['status_id'], 'in', 'range' => array_keys($this->getStatusList())],

            [['created_at', 'updated_at'], 'safe'],
            [['carousel_name', 'image_height', 'image_width'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'carousel_name' => 'Name',
            'image_height' => 'Height',
            'image_width' => 'Width',
            'carousel_autoplay' => 'Autoplay',
            'show_indicators' => 'Show Indicators',
            'show_caption_title' => 'Show Caption Title',
            'show_captions' => 'Show Captions',
            'show_caption_background' => 'Show Caption Background',
            'caption_font_size' => 'Caption Font Size',
            'show_controls' => 'Show Controls',
            'status_id' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'statusName' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    public function getStatusName()
    {
        return $this->status ? $this->status->status_name : '- no status -';
    }

    public static function getStatusList()
    {
        $droptions = Status::find()->asArray()->all();
        return ArrayHelper::map($droptions, 'id', 'status_name');
    }

    public static function getCarouselAutoplayList()
    {
        return $droptions = [0 => 'no', 1 => 'yes'];
    }

    public static function getShowIndicatorsList()
    {
        return $droptions = [0 => 'no', 1 => 'yes'];
    }

    public static function getShowCaptionsList()
    {
        return $droptions = [0 => 'no', 1 => 'yes'];
    }

    public static function getShowCaptionTitleList()
    {
        return $droptions = [0 => 'no', 1 => 'yes'];
    }

    public static function getShowCaptionBackgroundList()
    {
        return $droptions = [0 => 'no', 1 => 'yes'];
    }

    public static function getShowControlsList()
    {
        return $droptions = [0 => 'no', 1 => 'yes'];
    }
}
