<?php 

namespace components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use backend\models\MarketingImage;
use backend\models\search\MarketingImageSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CarouselWidget extends Widget
{
	public $activeImage;
	public $images;
	public $count;
	public $settings = [];

	public function init()
	{
		parent::init();

		$this->activeImage = MarketingImage::find('marketing_image_path')
					->where(['marketing_image_is_active' => 1])
					->andWhere(['marketing_image_is_featured' => 1])
					->andWhere(['status_id' => 1])
					->one();

		$this->images = MarketingImage::find()
					->where(['marketing_image_is_active' => 0])
					->andWhere(['marketing_image_is_featured' => 1])
					->andWhere(['status_id' => 1])
					->orderBy('marketing_image_weight')
					->all();
		$this->count = MarketingImage::find()
					->where(['marketing_image_is_active' => 0])
					->andWhere(['marketing_image_is_featured' => 1])
					->andWhere(['status_id' => 1])
					->count();
		$this->setDefaults();
		$this->validateSize();
	}

	public function setDefaults()
	{
		if (!isset($this->settings['height'])) {
			$this->settings['height'] = '300px';
		}

		if (!isset($this->settings['width'])) {
			$this->settings['width'] = '700px';
		}

		if (!isset($this->settings['autoplay'])) {
			$this->settings['autoplay'] = true;
		}

		if (!isset($this->settings['caption_font_size'])) {
			$this->settings['caption_font_size'] = '15px';
		}

		if (!isset($this->settings['show_indicators'])) {
			$this->settings['show_indicators'] = true;
		}

		if (!isset($this->settings['show_captions'])) {
			$this->settings['show_captions'] = false;
		}

		if (!isset($this->settings['show_caption_background'])) {
			$this->settings['show_caption_background'] = false;
		}

		if (!isset($this->settings['show_caption_title'])) {
			$this->settings['show_caption_title'] = false;
		}

		if (!isset($this->settings['show_controls'])) {
			$this->settings['show_controls'] = true;
		}
	}

	public function validateSize()
	{
		if (!preg_match("/px/", $this->settings['width']) or !preg_match("/px/", $this->settings['height'])) {
			throw new NotFoundHttpException('You Must Use px and number for size, example 300px');
		}

		$height = (int)preg_replace("/[^0-9]/", "", $this->settings['height']);

		switch ($height) {
			case $height < 40:
				throw new NotFoundHttpException('You Must Stay within 40 to 1000 px and use px and number for size, example 300px');
				break;

			case $height > 1000:
				throw new NotFoundHttpException('You Must Stay within 40 to 1000 px and use px and number for size, example 300px');
				break;
		}

		$width = (int)preg_replace("/[^0-9]/", "", $this->settings['width']);

		switch ($width) {
			case $width < 40:
				throw new NotFoundHttpException('You Must Stay within 40 to 1000 px and use px and number for size, example 300px');
				break;
			
			case $width > 1000:
				throw new NotFoundHttpException('You Must Stay within 40 to 1000 px and use px and number for size, example 300px');
				break;
		}
	}

	public function run()
	{
		return $this->render('carousel', 
			[
				'activeImage' => $this->activeImage,
				'images'	=> $this->images,
				'count'		=> $this->count,
				'settings' 	=> $this->settings,
			]);
	}
}