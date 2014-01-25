<?php

include_once('s1b_core.php');
$m = new sha1base();
$m->loadModule('s1b_mysql', 'sha1base_mysql', true); // 3rd argument supplied as true
$m->loadModule('s1b_mysqli', 'sha1base_mysqli', true); // prints loading state, e.g. [module]
$m->loadModule('s1b_sqlite', 'sha1base_sqlite', true); // sucessful loaded
$m->loadModule('s1b_filesystem', 'sha1base_filesystem', true);
$m->loadModule('s1b_network', 'sha1base_network', true);
$m->loadModule('s1b_media', 'sha1base_media', true);
$m->loadModule('s1b_hive', 'sha1base_hive', true);
$m->loadModule('s1b_location', 'sha1base_location', true);


?>
