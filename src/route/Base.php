<?php

namespace zf\router\route;

abstract class Base 
{
	protected $matcher;

	protected $flag;

	protected $callable;

	public function setFlag(IFlag $flag, $callable)
	{
		$this->flag = $flag;
		$this->callable = $callable;
	}


	public function match(IFlag $currentFlag)
	{
		$res = $this->matcher->match($this->flag, $currentFlag);
		return $res ? $this->callable : false; 
	}

}