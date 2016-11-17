<?php 

namespace frontend\models;

use Yii;
use yii\base\Model; // 该基类通常用来表示数据

class EntryForm extends Model
{
	public $name;
	public $email;

	public function rules()
	{
		return [
			[['name', 'email'], 'required'],
			['email', 'email'],
		];
	}
}