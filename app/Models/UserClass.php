<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserClass extends Model {
	
	protected $table = "user_class";

	public $timestamps = false;

	protected $fillable = [
		"id_user",
		"id_class",
		"admin"
	];

}