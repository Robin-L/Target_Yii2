<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Faq;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\data\ArrayDataProvider;

/**
 * FaqSearch represents the model behind the search form about `backend\models\Faq`.
 */
class FaqSearch extends Faq
{
    public $faqCategoryName;
    public $faqCategoryList;
    public $faqIsFeaturedName;
    public $createdByUsername;
    public $updatedByUsername;
    public $faq_category;
    public $faq_weight;
    public $modelAttribute;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'faq_category_id', 'faq_is_featured', 'faq_weight', 'created_by', 'updated_by'], 'integer'],
            [['faq_question', 'faq_answer', 'created_at', 'updated_at', 'faqCategoryName', 'faqCategoryList', 'faqIsFeaturedName', 'createdByUsername', 'updatedByUsername', 'faq_category', 'faq_weight'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Faq::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder'  => ['faq_weight' => SORT_ASC,],
            'attributes'    => [
                'id',
                'faq_question' => [
                    'asc' => ['faq.faq_question' => SORT_ASC],
                    'desc'=> ['faq.faq_question' => SORT_DESC],
                    'label' => 'Question'
                ],
                'faq_answer' => [
                    'asc' => ['faq.faq_answer' => SORT_ASC],
                    'desc'=> ['faq.faq_answer' => SORT_DESC],
                    'label' => 'Answer'
                ],
                'faqCategoryName' => [
                    'asc' => ['faq_category.faq_category_name' => SORT_ASC],
                    'desc'=> ['faq_category.faq_category_name' => SORT_DESC],
                    'label' => 'Category'
                ],
                'faq_weight' => [
                    'asc' => ['faq.faq_weight' => SORT_ASC],
                    'desc'=> ['faq.faq_weight' => SORT_DESC],
                    'label' => 'Answer'
                ],
                'faqIsFeaturedName' => [
                    'asc' => ['faq.faq_is_featured' => SORT_ASC],
                    'desc'=> ['faq.faq_is_featured' => SORT_DESC],
                    'label' => 'Featured?'
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->joinWith(['faqCategory']);
            return $dataProvider;
        }

        $this->addSearchParameter($query, 'id');
        $this->addSearchParameter($query, 'faq_category_id');
        $this->addSearchParameter($query, 'faq_weight');
        $this->addSearchParameter($query, 'faq_is_featured');
        $this->addSearchParameter($query, 'created_by');
        $this->addSearchParameter($query, 'updated_by');
        $this->addSearchParameter($query, 'faq_question', true);
        $this->addSearchParameter($query, 'faq_answer', true);

        $query->joinWith(['faqCategory' => function($q) {
            $q->andFilterWhere(['=', 'faq_category.faq_category_name', $this->faqCategoryName]);
        }]);

        return $dataProvider;
    }

    protected function addSearchParameter($query, $attribute, $partialMatch = false)
    {
        if (($pos = strrpos($attribute, '.')) !== false) {
            $modelAttribute = substr($attribute, $pos + 1);
        } else {
            $modelAttribute = $attribute;
        }

        $value = $this->$modelAttribute;
        if (trim($value) === '') {
            return ;
        }
        $attribute = "faq.$attribute";
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }

    public function frontendProvider()
    {
        $query = new Query;
        $provider = new ArrayDataProvider([
            'allModels' => $query->from('faq')->all(),
            'sort' => [
                'defaultOrder' => [
                    'faq_weight' => SORT_ASC,
                ],
                'attributes' => ['faq_question', 'faq_answer', 'faq_weight'],
            ],
            'pagination' => [
                'pageSize' => 10
            ],
        ]);
        return $provider;
    }
}
