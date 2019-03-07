<?php
use LSYS\SphinxClient\DI;

include __DIR__."/Bootstarp.php";

$r=DI::get()->sphinxClient()->Query("ddd");
print_r($r===false?DI::get()->sphinxClient()->GetLastError():$r);