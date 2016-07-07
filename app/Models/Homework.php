<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model {
	
	protected $table = "homeworks";

	public $timestamps = false;

	protected $fillable = [
		"id_class",
		"id_subject",
		"id_description",
		"id_consignDate"
	];

}