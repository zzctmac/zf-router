<?php
namespace zf\router\matcher;
use zf\router\route\WebFlag;

class Simple extends Base 
{

	protected static $regexTable = [
		'number'=>"([-+]?\d+(\.\d+)?)",
		'int'=>"([-+]?\d+)",
		'string'=>'(.*)'
	];

	protected static function equal($analyseResult, $current) {
		return $analyseResult['uri'] === $current;
	}

	protected static function regex($analyseResult, $current) {
		$res = preg_match_all($analyseResult['pattern'], $current, $m);
		if(!$res) {
			return false;
		}

		$index = 1;
		$res = [];

		foreach ($analyseResult['field_map'] as $key => $value) {
			$tmp = $m[$index++][0];
			if($value[1] == 'int') {
				$tmp = intval($tmp);
			} elseif($value[1] == "number") {
				$tmp = $tmp + 0;
			}
			$res[$value[0]] = $tmp;
		}
		return $res;

	}

	protected static $analyseResult = [];

	protected static function analyse(WebFlag $refer) {
		$name = $refer->serialize();
		if(!isset(static::$analyseResult[$name])) {
			$res = ['method'=>$refer->getMethod()];
			$uri = $refer->getUri();
			$fieldPattern = "(<[^/]*>)";
			$resNum = preg_match_all($fieldPattern, $uri, $matches);
			if($resNum > 0) {
				$fieldMap = [];
				foreach ($matches[0] as  $field) {
					$origin = $field;
					$field = substr($field, 1, strlen($field) - 2);
					$fieldInfo = explode(':', $field);
					if(count($fieldInfo) == 1) {
						$fieldInfo[] = "string";
					}

					if(!isset(static::$regexTable[$fieldInfo[1]])) {
						$fieldInfo[1] = "string";
					}
					$regex = static::$regexTable[$fieldInfo[1]];
					$fieldInfo[] = $regex;

					$fieldMap[$origin] = $fieldInfo;
				}

				$pattern = $uri;
				foreach ($fieldMap as $origin => $info) {
					$pattern = str_replace($origin, $info[2], $pattern);
				}

				$pattern = str_replace("/", "\/", $pattern);
				$pattern = "/^" . $pattern . "$/";
				$res['match_type'] = 'regex';
				$res['field_map'] = $fieldMap;
				$res['pattern'] = $pattern;
			} else {
				$res['match_type'] = 'equal';
				$res['uri'] = $uri;
			}


			static::$analyseResult[$name] = $res;
		}
		return static::$analyseResult[$name];
	}

	public function match(WebFlag $refer = null, WebFlag $current = null)
	{
			// 判断 method
			do{
				if($refer->isAnyMethod()) {
					break;
				}
				if($refer->getMethod() !== $current->getMethod()) {
					return false;
					break;
				}
			}while (false);

			$analyseResult = static::analyse($refer);

			$callback = array(self::class, $analyseResult['match_type']);

			return call_user_func($callback, $analyseResult, $current->getUri());

	}
}