<?php

$regexTable = [
		'number'=>"([-+]?\d+(\.\d+)?)",
		'int'=>"([-+]?\d+)",
		'string'=>"(.+)"
	];

$url = "/person/<name>/<age:int>";

$re = "(<[^/]*>)";



$res = preg_match_all($re, $url, $matches);

var_dump($res);

if($res > 0) {
	$fieldMap = [];
	foreach ($matches[0] as  $field) {
		$origin = $field;
		$field = substr($field, 1, strlen($field) - 2);
		$fieldInfo = explode(':', $field);
		if(count($fieldInfo) == 1) {
			$fieldInfo[] = "string";
		}

		if(!isset($regexTable[$fieldInfo[1]])) {
			$fieldInfo[1] = "string";
		}
		$regex = $regexTable[$fieldInfo[1]];
		$fieldInfo[] = $regex;

		$fieldMap[$origin] = $fieldInfo;
	}

	$pattern = $url;
	foreach ($fieldMap as $origin => $info) {
		$pattern = str_replace($origin, $info[2], $pattern);
	}

	$pattern = str_replace("/", "\/", $pattern);
	$pattern = "/^" . $pattern . "$/";



	$su = "/person/zzc/18";
	

	$r = preg_match_all($pattern, $su, $m);
	var_dump($r);
	print_r($m);
	print_r($fieldMap);

}