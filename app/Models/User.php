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
		"updated_at"
	];

}