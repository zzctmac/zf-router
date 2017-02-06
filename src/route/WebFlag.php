<?php

namespace zf\router\route;

final class WebFlag implements IFlag
{
	private $uri;
	private $method;

	const GET = "GET";
	const POST = "POST";
	const ANY = "ANY";

	public function isAnyMethod()
	{
		return $this->method === self::ANY;
	}

	public function isGetMethod() 
	{
		return $this->method === self::GET;
	}

	public function isPostMethod()
	{
		return $this->method === self::POST;
	}

	public static function create($uri, $method = self::ANY) 
	{
		return new self($uri , $method);
	}

	public function __construct($uri, $method)
	{
		$this->uri = $uri;
		$this->method = $method;
	}

	public function getUri()
	{
		return $this->uri;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public static function getFlag($uri, $method)
	{
		return new self($uri, $method);
	}

	public function serialize()
	{
		return md5($this->method . $this->uri);
	}

}