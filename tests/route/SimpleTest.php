<?php
use zf\router\route\WebFlag;
use zf\router\matcher\Simple;


class SimpleRouteTest extends PHPUnit_Framework_TestCase {
		
		public function testRegex() 
		{
			$matcher = new Simple();
			$refer = WebFlag::create("/person/<name>/<id:int>");
			$c1 = WebFlag::create("/person/zzc/12", WebFlag::GET);
			$r1 = $matcher->match($refer, $c1);
			$this->assertEquals('zzc', $r1['name']);
			$this->assertEquals(12, $r1['id']);

			$c2 = WebFlag::create("/perso/zzc", WebFlag::GET);
			$r2 = $matcher->match($refer, $c2);
			$this->assertFalse($r2);
		}

		public function testUnRegx()
		{
			$matcher = new Simple();
			$refer = WebFlag::create("/person/zzc");
			$c1 = WebFlag::create("/person/zzc", WebFlag::GET);
			$r1 = $matcher->match($refer, $c1);
			$this->assertTrue($r1);

			$c2 = WebFlag::create("/perso/zzc", WebFlag::GET);
			$r2 = $matcher->match($refer, $c2);
			$this->assertFalse($r2);
		}
}