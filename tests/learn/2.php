<?php

$pattern = "/(.*)\/([-+]?\d+)/";

$subject = "zzc/12";

preg_match_all($pattern, $subject, $matches);

print_r($matches);