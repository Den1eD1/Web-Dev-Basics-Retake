<?php
$cnf['admin']['namespace'] = 'Controllers\Admin';

$cnf['administration']['namespace'] = "Controllers\\Admin";
$cnf['administration']['controllers']['index']['to'] = "test";
$cnf['administration']['controllers']['index']['methods']['new'] = "_new";

$cnf['administration']['controllers']['new']['to'] = "create";

$cnf['*']['namespace'] = 'Controllers';

return $cnf;