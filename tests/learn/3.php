<?php

declare(strict_types=1);

include '../vendor/autoload.php';

use zf\router\route\WebFlag;

$matcher = new zf\router\matcher\Simple();

$refer = WebFlag::create("/person/<name>/<age:int>");

$current = WebFlag::create("/person/zzc/12", WebFlag::GET);

$res = $matcher->match($refer, $current);

var_dump($res);


$current = WebFlag::create("/person/zzc12/zzc", WebFlag::GET);

$res = $matcher->match($refer, $current);

var_dump($res);

$refer = WebFlag::create("/person/zzc12/zzc");

$res = $matcher->match($refer, $current);

var_dump($res);

