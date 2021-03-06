<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
	
	protected $table = "users";

	protected $fillable = [
		"email",
		"password",
		"name",
		"surname",
		"active",
		"created_at",
		"updated_at",
		"tag"
	];

	public function setPassword($password) {

		$this->update([
			"password" => password_hash($password, PASSWORD_DEFAULT)
		]);

	}

	public function classes() {
		return $this->belongsToMany('App\Models\Classe', "user_class", "id_user", "id_class");
	}

}