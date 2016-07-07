<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model {
	
	protected $table = "subjects";

	public $timestamps = false;

	protected $fillable = [
		"name",
		"id_class"
	];

	public function classe() {
    	return $this->belongsTo("App\Models\Classe", "id_class");
    }

}