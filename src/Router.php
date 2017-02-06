<?php

namespace zf\router;

class Router implements Base, \IteratorAggregate {

	protected static $ins;

	protected $routes = [];

	public static function getInstance():Router
	{
		if(!$ins instanceof static)
			$ins = new static();
		return $ins;
	}

	protected __consturct() 
	{

	}

	public function getIterator() 
	{
        foreach ($this->routers as $key => $value) {
        	yield ($key=>$value);
        }
    }



	public function addRoute(route\base $r)
	{
		$this->route[] = $r;
	}


	public function match(route\IFlag $flag)
	{
		$gen = $this->getIterator();
		foreach ($gen as  $route) {
			$res = $route->match($flag);
		}
		return false;
	}
}