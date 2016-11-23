<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use kartik\widgets\StarRating;

/**
 * This is the model class for table "faq_rating".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $faq_id
 * @property double $faq_rating
 * @property string $created_at
 * @property string $updated_at
 */
class FaqRating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq_rating';
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
        ];
    }

    public function beforeValidate()
    {
        $this->faq_rating = (double)$this->faq_rating;
        $this->faq_id = (int)$this->faq_id;
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'faq_id', 'faq_rating'], 'required'],
            [['user_id', 'faq_id'], 'integer'],
            [['faq_rating'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'faq_id' => 'Faq ID',
            'faq_rating' => 'Faq Rating',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function showAverageRating($faq_id)
    {
        $averageRating = $this->getAverageRating($faq_id);
        echo StarRating::widget([
            'name'  => 'rating_'.$averageRating,
            'value' => $averageRating,
            'disabled' => true,
            'pluginOptions' => [
                'size' => 'sm',
                'stars'=> 5,
                'min'  => 0,
                'max'  => 5,
                'step' => 0.5,
                'starCaptions' => []
            ]
        ]);
    }

    public function getAverageRating($faq_id)
    {
        $ratings = FaqRating::find('faq_rating')->asArray()->where(['faq_id' => $faq_id])->all();
        $ratings = ArrayHelper::map($ratings, 'id', 'faq_rating');
        
        $ratingsSum = array_sum($ratings);
        $ratingsCount = count($ratings);

        if ($ratingsCount) {
            $averageRating = $ratingsSum/$ratingsCount;
        } else {
            $averageRating = 0;
        }
        return  $averageRating;
    }
}
