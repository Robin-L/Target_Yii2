<?php 

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MarketingImage;

class MarketingImageSearch extends MarketingImage
{
	public $statusName;

	public function rules()
	{
		return [
			[['id', 'marketing_image_is_featured', 'marketing_image_is_active', 'status_id'], 'integer'],
			[['marketing_image_path', 'marketing_image_name', 'marketing_image_caption', 'marketing_image_caption_title', 'marketing_image_weight', 'created_at', 'statusName', 'updated_at'], 'safe'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = MarketingImage::find();

		$dataProvider = new ActiveDataProvider(['query' => $query]);

		$dataProvider->setSort([
			'attributes' => [
				'id',
				'marketing_image_name',
				'marketing_image_path',
				'marketing_image_caption',
				'marketing_image_is_featured',
				'marketing_image_is_active',
				'marketing_image_weight',
				'statusName' => [
					'asc' => ['status.status_name' => SORT_ASC],
					'desc'=> ['status.status_name' => SORT_DESC],
					'label' => 'Status'
				],
			]
		]);

		if (!($this->load($params) && $this->validate())) {
			$query->joinWith(['status']);
			return $dataProvider;
		}

		$this->addSearchParameter($query, 'id');
		$this->addSearchParameter($query, 'marketing_image_name', true);
		$this->addSearchParameter($query, 'marketing_image_path', true);
		$this->addSearchParameter($query, 'marketing_image_caption', true);
		$this->addSearchParameter($query, 'marketing_image_caption_title', true);
		$this->addSearchParameter($query, 'marketing_image_is_featured');
		$this->addSearchParameter($query, 'marketing_image_is_active');
		$this->addSearchParameter($query, 'marketing_image_weight');
		$this->addSearchParameter($query, 'status_id');

		$query->joinWith(['status' => function($q) {
			$q->andFilterWhere(['=', 'status.status_name', $this->statusName]);
		}]);

		return $dataProvider;
	}

	protected function addSearchParameter($query, $attribute, $partialmatch = false)
	{
		if (($pos = strrpos($attribute, '.')) !== false) {
			$modelAttribute = substr($attribute, $pos+1);
		} else {
			$modelAttribute = $attribute;
		}

		$value = $this->$modelAttribute;
		if (trim($value) === '') {
			return;
		}

		$attribute = "marketing_image.$attribute";
		if ($partialmatch) {
			$query->andWhere(['like', $attribute, $value]);
		} else {
			$query->andWhere([$attribute => $value]);
		}
	}
}
