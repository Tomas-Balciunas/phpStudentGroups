<?php

use NFQ\DB;
use NFQ\Tasks;
use NFQ\Request;

$id = intval(basename(Request::uri()));
$connection = DB::connect();
$task = new Tasks($connection);
$task->updateStudent($id, $_POST);

header('Location:/nfq/');