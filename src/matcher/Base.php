<?php

namespace zf\router\matcher;
use zf\router\route\IFlag;


abstract class Base 
{
	abstract public function match();
}