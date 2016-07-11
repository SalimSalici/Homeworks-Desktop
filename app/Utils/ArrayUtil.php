<?php

namespace App\Utils;

class ArrayUtil {

	public static function arraySort($input, $sortkey) {
		$output = [];
		foreach ($input as $key=>$val) $output[$val[$sortkey]][]=$val;
		return $output;
	}

	public static function arrayObjectToNumericSelect($input, $field) {
		$output = [];
		foreach ($input as $key => $val) $output[] = $val[$field];
		return $output;
	}

}