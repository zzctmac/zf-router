<?php

namespace zf\router\route;

class Web extends Base
{
	
	public function set($method, $uri, $callable)
	{
		$flag = new WebFlag($method, $uri);
		$this->setFlag($flag, $callable);
	}	

}