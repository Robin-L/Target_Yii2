<?php 
namespace components;

use yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class MyComponent extends Component
{
	public function blastOff()
	{
		echo "Houston, we have ignition...";
	}
}