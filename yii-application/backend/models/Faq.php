<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use backend\models\FaqCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\User;

/**
 * This is the model class for table "faq".
 *
 * @property integer $id
 * @property string $faq_question
 * @property string $faq_answer
 * @property integer $faq_category_id
 * @property integer $faq_is_featured
 * @property integer $faq_weight
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['faq_question', 'faq_answer'], 'required'],
            [['faq_category_id', 'faq_is_featured', 'faq_weight', 'created_by', 'updated_by'], 'integer'],
            [['faq_weight'], 'in', 'range' => range(1, 100)],
            ['faq_weight', 'default', 'value' => 100],
            [['created_at', 'updated_at'], 'safe'],
            [['faq_question'], 'string', 'max' => 255],
            [['faq_question'], 'unique'],
            [['faq_answer'], 'string', 'max' => 1055],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'faq_question' => 'Question',
            'faq_answer' => 'Answer',
            'faq_category_id' => 'Category',
            'faq_is_featured' => 'Featured?',
            'faq_weight' => 'Weight',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'faqCategoryName' => Yii::t('app', 'Category'),
            'faqCategoryList' => Yii::t('app', 'Category'), 
            'faqIsFeatruedName' => Yii::t('app', 'Featured'),
            'createdByUserName' => Yii::t('app', 'Created By'), 
            'updatedByUserName' => Yii::t('app', 'Updated By'),
        ];
    }

    public function getFaqCategory()
    {
        return $this->hasOne(FaqCategory::className(), ['id' => 'faq_category_id']);
    }

    public function getFaqCategoryName()
    {
        return $this->faqCategory->faq_category_name;
    }

    public static function getFaqCategoryList()
    {
        $droptions = FaqCategory::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'faq_category_name');
    }

    public static function getFaqIsFeaturedList()
    {
        return $droptions = [0 => 'no', 1 => 'yes'];
    }

    public function getFaqIsFeaturedName()
    {
        return $this->faq_is_featured == 0 ? 'no' : 'yes';
    }

    public function getCreatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getCreatedByUsername()
    {
        return $this->createdByUser ? $this->createdByUser->username : ' -no user -';
    }

    public function getUpdatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getUpdatedByUsername()
    {
        return $this->updatedByUser ? $this->updatedByUser->username : '- no user -';
    }

}
