<?php

use NFQ\DB;
use NFQ\Tasks;
use NFQ\Request;

$id = intval(basename(Request::uri()));
$connection = DB::connect();
$task = new Tasks($connection);
$task->addStudent($id, $_POST);

header('Location:/nfq/');
