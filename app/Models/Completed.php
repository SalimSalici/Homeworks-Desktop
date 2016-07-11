<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Completed extends Model {
	
	protected $table = "completed";

	public $timestamps = false;

	protected $fillable = [
		"id_user",
        "id_homework"
	];

	public static function getCompletedByClassAndUser($class, $user) {

		return self::select("id_user", "id_homework")
			->join("homeworks", "homeworks.id", "=", "completed.id_homework")
			->where("id_user", $user->id)
			->where("homeworks.id_class", $class->id);

	}

}