<?php

include 'mysqlbackup.php';
$dump = new Ifsnop\Mysqldump\Mysqldump('mysql:host=localhost;dbname=profiling', 'root', '');
$dump->start('db/profiling.sql');
header('Content-type: sql');
header('Content-Disposition: attachment; filename="profiling.sql"');
readfile('db/profiling.sql');
