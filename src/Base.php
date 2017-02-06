<?php

namespace zf\router;


interface Base {
	public function addRoute(route $r);
	public function match(): ?route;
}