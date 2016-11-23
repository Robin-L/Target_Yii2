<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;

/**
 * This is the model class for table "marketing_image".
 *
 * @property string $id
 * @property string $marketing_image_path
 * @property string $marketing_image_name
 * @property string $marketing_image_caption
 * @property integer $marketing_image_is_featured
 * @property integer $marketing_image_is_active
 * @property integer $marketing_image_weight
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Status $status
 */
class MarketingImage extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'marketing_image';
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
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['marketing_image_path', 'marketing_image_name', 'marketing_thumb_path', 'marketing_image_weight', 'file'], 'required'],
            ['marketing_image_weight', 'default', 'value' => 100],
            ['marketing_image_is_featured', 'default', 'value' => 0],
            ['marketing_image_is_active', 'default', 'value' => 0],

            ['file', 'required', 'message' => '{attribute} can\'t be blank', 'on' => 'create'],

            [['marketing_image_is_featured'], 'in', 'range' => array_keys($this->getMarketingImageIsFeaturedList())],
            [['marketing_image_is_active'], 'in', 'range' => array_keys($this->getMarketingImageIsActiveList())],

            [['marketing_image_name', 'marketing_image_path'], 'trim'],
            [['marketing_image_caption', 'marketing_image_caption_title'], 'string', 'max' => 100],
            [['marketing_image_is_featured', 'marketing_image_is_active', 'marketing_image_weight', 'status_id'], 'integer'],
            [['file'], 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024],
            [['marketing_image_path', 'marketing_image_name'], 'string', 'max' => 45]
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['file', 'marketing_image_path', 'marketing_image_name', 'marketing_thumb_path', 'marketing_image_is_featured', 'marketing_image_is_active', 'marketing_image_caption', 'marketing_image_caption_title', 'marketing_image_weight'];
        return $scenarios;
    }

    public function beforeValidate()
    {
        $this->marketing_image_name = preg_replace('/\s+/', '', $this->marketing_image_name);
        $this->marketing_image_path = preg_replace('/\s+/', '', $this->marketing_image_path);
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'marketing_image_path' => 'Marketing Image Path',
            'marketing_image_name' => 'Marketing Image Name',
            'marketing_image_caption' => 'Caption',
            'marketing_image_caption_title' => 'Caption Title',
            'marketing_image_is_featured' => 'Marketing Image Is Featured',
            'marketing_image_is_active' => 'Marketing Image Is Active',
            'marketing_image_weight' => 'Marketing Image Weight',
            'status_id' => 'Status ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'file'       => 'Marketing Image',
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

    public function getMarketingImageIsFeaturedList()
    {
        return $droptions = [0 => 'no', 1 => 'yes'];
    }

    public function getMarketingImageIsActiveList()
    {
        return $droptions = [0 => 'no', 1 => 'yes'];
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

    public function getThumb()
    {
        $image = Html::img('/'.$this->marketing_thumb_path);
        return Html::a($image, ['view', 'id' => $this->id]);
    }
}
