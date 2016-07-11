<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserClass;

class Classe extends Model {
	
	protected $table = "classes";

	public $timestamps = false;

	protected $fillable = [
		"name",
		"password",
		"id_creator",
		"id_accessibility",
		"tag"
	];

	public function setPassword($password) {

		$this->update([
			"password" => password_hash($password, PASSWORD_DEFAULT)
		]);

	}

	public function subjects() {
        return $this->hasMany("App\Models\Subject", "id_class");
    }

    public function homeworks() {
    	return $this->hasMany("App\Models\Homework", "id_class");
    }

    public function hasAdmin($user) {

    	$where = [
    		"id_class" => $this->id,
    		"id_user" => $user->id
    	];

    	$userClass = UserClass::where($where)->first();

    	if ($userClass === null) return false;

    	return $userClass->admin === 1 ? true : false;

    }

    public function hasMember($user) {

    	$where = [
    		"id_class" => $this->id,
    		"id_user" => $user->id
    	];

    	$userClass = UserClass::where($where)->first();

    	return $userClass === null ? false : true;

    }

}