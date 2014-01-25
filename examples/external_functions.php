<?php

include_once('s1b_core.php');
$m = new sha1base();
$m->loadModule('s1b_network', 'sha1base_network', true);

echo $m->callExtFunc('sha1base_network', 'ping', 'http://google.de/');
// To call any external function you'll need:
// module name, as defined with loadModule,
// function name to call,
// and arguments you want to pass.
// if you want to supply a function with multiple arguments, use an array:
echo $m->callExtFunc('sha1base_network', 'startDl', array('file_hash',500*1024));

?>
