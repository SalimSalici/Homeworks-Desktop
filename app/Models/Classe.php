<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model {
	
	protected $table = "classes";

	public $timestamps = false;

	protected $fillable = [
		"name",
		"password",
		"id_creator",
		"id_accessibility"
	];

	public function setPassword($password) {

		$this->update([
			"password" => password_hash($password, PASSWORD_DEFAULT)
		]);

	}

}