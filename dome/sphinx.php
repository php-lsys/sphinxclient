<?php
use LSYS\SphinxClient\DI;

include __DIR__."/Bootstarp.php";

$r=DI::get()->sphinx_client()->Query("ddd");
print_r($r===false?DI::get()->sphinx_client()->GetLastError():$r);