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

	public function classe() {
    	return $this->belongsTo("App\Models\Classe", "id_class");
    }

    public function subject() {
    	return $this->belongsTo("App\Models\Subject", "id_subject");
    }

    public static function getHomeworksByClass($class) {

    	$homeworks = self::select("homeworks.description", "subjects.name as subject", "homeworks.consignDate")
    		->join("subjects", "subjects.id", "=", "homeworks.id_subject")
    		->where("homeworks.id_class", $class->id)
    		->orderBy("consignDate");

    	return $homeworks;

    }

}