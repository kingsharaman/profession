<?php

namespace app\models;

use yii\base\Model;

class ListingForm extends Model
{
    public $id;
	public $title;
    public $status;
	public $activated;
	public $email;

    public function rules()
    {
		return [
			[['id', 'title', 'status', 'activated'], 'string', 'min' => 0],
			['email', 'email']
		];
    }
}